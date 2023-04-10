#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ESP8266HTTPClient.h>
#include <NTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiUdp.h>

// variables to parse the string from the arduino
String input;
bool flag;

// username and password of the Wi-Fi network
const char *username =  "<INSERT USERNAME>";     
const char *pass =  "<INSERT PASSWORD>";

// the following paylaod is the request body of the http post request
String payload =  "{\"user\": \"Billy123\",\"dog\" : \"Doguino\",";

// dogdataAPI is the name of the php API file
// the IP should be replaced by the host IP 
String serverName = "http://172.20.10.2:8080/dogdataAPI.php";

// record timestamps
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 0);
unsigned long epochTime;

void setup() 
{
      // establish a Wi-Fi connection
      input = "";
      flag = false;
      Serial.begin(115200);
      delay(10);
               
      Serial.println("Connecting to ");
      Serial.println(username); 
    
      WiFi.begin(username, pass); 
      // loop until the Wi-Fi connection is established 
      while (WiFi.status() != WL_CONNECTED) 
          {
            delay(500);
            Serial.print(".");
          }
          
      Serial.println("");
      Serial.println("WiFi connected"); 

    timeClient.begin();
    timeClient.setTimeOffset(0);
}
 

void loop() {
  // wait one minute for the Arduino input
  delay(60000);

  // parse the string from the Arduino 
  while (Serial.available()) {
    char c = Serial.read();
    if(c== '*'){
      flag = true;
    }
    // exit when string is finished 
    if(c== ';'){
      break;
    }
    if(flag==true && c!= '*'){
      input += String(c);
    }
  }
  
  Serial.println(input);
  flag = false;
 
  // update the time and retrieve the date in the format
  // YYYY-MM-DD 
  // get the time in this format:
  // HH:MM:SS
 timeClient.update();
  int hours = timeClient.getHours();
  int minutes = timeClient.getMinutes();
  int seconds = timeClient.getSeconds();
  String hourString = "";
  String minuteString = "";
  String secString = "";
  if(hours  < 10){
    hourString = "0"+String(hours);
  }else{
    hourString = String(hours);
  }
  if(minutes  < 10){
    minuteString = "0"+String(minutes);
  }else{
    minuteString = String(minutes); 
  }
  if(seconds  < 10){
    secString = "0"+String(seconds);
  }else{
    secString = String(seconds); 
  }
  String timeString = hourString+":" + minuteString + ":" + secString;
  // date retrival
  epochTime = timeClient.getEpochTime();
  struct tm *ptm = gmtime ((time_t *)&epochTime);
  int monthDay = ptm->tm_mday;
  int currentMonth = ptm->tm_mon+1;
  int currentYear = ptm->tm_year+1900;
  String month = "";
  String day = "";
  // add a zero for consistent date fromatting if the number is below 10
  if(monthDay < 10){
    day = "0"+String(monthDay);
  }else{
     day = String(monthDay);
  }
  if(currentMonth < 10){
    month = "0"+String(currentMonth);
  }else{
    month = String(currentMonth); 
  }
  String currentDate = String(currentYear) + "-" + month + "-" + day;
  Serial.print("Current date: ");
  Serial.println(currentDate);
  Serial.println(timeString);
 
  String temp = payload;


  //Check if connected before sending the POST request
  if(WiFi.status()== WL_CONNECTED){
    WiFiClient client;
    HTTPClient http;
    
    // begin a session with the web server
    http.begin(client, serverName);
    
    // the request body is type JSON
    http.addHeader("Content-Type", "application/json");
    temp += "\"date\" : \""+ currentDate+"\", \"time\" : \""+timeString+"\","+input+ "}";
    Serial.print(temp);
    // the request is sent 
    int httpCode   = http.POST(temp);

    Serial.print("HTTP Response code: ");
    Serial.println(httpCode);
       
    // free the http ressource 
    http.end();
  }
  else {
    Serial.println("Wi-Fi Disconnected");
  }
  // reset the input string 
  input = "";
}
