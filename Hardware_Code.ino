#define USE_ARDUINO_INTERRUPTS true    // Set-up low-level interrupts for most acurate BPM math.
#include <PulseSensorPlayground.h>     // Include PulseSensorPlayground library. 
#include "Wire.h"                      // Including I2C library to use I2C devices (SCA and SCL).  
#include <SoftwareSerial.h>

SoftwareSerial espSerial(5, 6);        // Pins 5,6 used for the WIFI Module
//  Variables
const int PulseWire = 0;               // PulseSensor PURPLE WIRE connected to ANALOG PIN 0
const int LED = 0;                     // The on-board Arduino LED, close to PIN 13.
int Threshold = 550;                   // Determine which Signal to "count as a beat" and which to ignore.
                                       // Use the "Gettting Started Project" to fine-tune Threshold Value beyond default setting.
                                       // Otherwise leave the default "550" value. 
                               
PulseSensorPlayground pulseSensor;     // Created object called "pulseSensor"
unsigned long millisCurrentmin;
unsigned long millisLasmin;
bool flag ;
unsigned long minute1 = 60000;
float threshold_steps = 6;
const int OUT_PIN = 8;                 //Output signal pin for the microphone
const int SAMPLE_TIME = 10;
unsigned long millisCurrent;
unsigned long millisLast = 0;
unsigned long millisElapsed = 0;
int sampleBufferValue = 0;
const byte sample_buffer_array_size = 200;    // 1000 is just the max value, change it if more data it needed
int sampleBufferValue_array[sample_buffer_array_size]; 
int index_for_sampleBufferValue_array = 0;

const int MPU_ADDR = 0x68;                    // I2C address of the MPU-6050 accelerometer

int16_t accelerometer_x, accelerometer_y, accelerometer_z;    // accelerometer axis variables
int16_t gyro_x, gyro_y, gyro_z;                               // gyroscope axis variables
int16_t temperature;                                          // temprature variable

char tmp_str[7]; // temporary variable used in convert function

char* convert_int16_to_str(int16_t i) { // converts int16 to string. Moreover, resulting strings will have the same length in the debug monitor.
  sprintf(tmp_str, "%6d", i);
  return tmp_str;
}

//BMP085 Pressure Sensor
#include <Wire.h>
#include <Adafruit_BMP085.h>
#define seaLevelPressure_hPa 1013.25

Adafruit_BMP085 bmp;

//Heart Rate Monitor Variables

long beat_captured_now = 0; // in milliseconds
int total_heart_beats = 0;
int how_many_times_did_heart_beats_get_recorded = 0;

//Steps varibales taken from Accelerometer

long step_captured_now = millis();
int total_steps_taken = 0;

// Variables for readings

long reading_captured_now = millis();
float total_temp_taken = 0;
float how_many_times_did_temp_get_recorded = 0;
float total_pressure_taken = 0;
float how_many_times_did_pressure_get_recorded = 0;
float total_altitude_taken = 0;
float how_many_times_did_altitude_get_recorded = 0;



void setup() { 
// For Serial Monitor  

    Serial.begin(115200);          
    espSerial.begin(115200);
    
//Heart Rate Sensor

// Configure the PulseSensor object, by assigning our variables to it. 
  pulseSensor.analogInput(PulseWire);   
  pulseSensor.blinkOnPulse(LED);       //Using Arduino LED to indicate if heartrate occur
  pulseSensor.setThreshold(Threshold);   

// Verifying if a pulse sensor object has been created and the sensor is able to be used for readings. 
   if (pulseSensor.begin()) {
    Serial.println("Pulsesensor Object Created");  //This prints once intitally in the program 
  }
  
//Accelerometer

  Wire.begin();
  Wire.beginTransmission(MPU_ADDR); // Begin using the I2C
  Wire.write(0x6B);                 // PWR_MGMT_1 register from the datasheet to read and write
  Wire.write(0);                    // Setting to zero turns on the M6050 accelerometer
  Wire.endTransmission(true);
  
//Pressure and Temprautre Readings
  if (!bmp.begin()) {               //Checks if the BMP085 sensor is working and can operate
    Serial.println("Could not find a valid BMP085 sensor, check wiring!");
    while (1) {}
  }
  
//Microphone/Sound Sensor

millisLast= millis();
millisLasmin = millis();
flag = false;

}


void loop() {

//HeartBeat Sensor

if(millis() - beat_captured_now > 20){             // Sampled heartbeat duration
   
  if (pulseSensor.sawStartOfBeat()) {              // Checking constantly is a heartbeat occured
    int myBPM = pulseSensor.getBeatsPerMinute();   // Storing the reading as an integer in myBPM
    total_heart_beats = total_heart_beats + myBPM;
     how_many_times_did_heart_beats_get_recorded = how_many_times_did_heart_beats_get_recorded + 1; //Incremeting number of times BPM recorded
  }
  beat_captured_now = millis();
 
}


//Microphone
 millisCurrent = millis();
 millisLast = millisCurrent;
 millisElapsed = millisCurrent - millisLast;


// Capture sound for 10 milliseconds 
while(millisElapsed < SAMPLE_TIME){
  
   millisCurrent = millis();
 millisElapsed = millisCurrent - millisLast;
 if (digitalRead(OUT_PIN) == LOW) {
  sampleBufferValue++;
  if(millisElapsed <0){
    break;
    }
  }
}

// Sound recorded if above 0, the code will be sampled and placed into the array
 if (millisElapsed >= SAMPLE_TIME && index_for_sampleBufferValue_array < 20) {
  if(sampleBufferValue>0){
    sampleBufferValue_array[index_for_sampleBufferValue_array] = sampleBufferValue;
    index_for_sampleBufferValue_array = index_for_sampleBufferValue_array + 1;
  } 
  
  sampleBufferValue = 0;
  millisLast = millisCurrent;
  }


//Accelerometer and Gyroscope

if(millis() - step_captured_now > 1000){
Wire.beginTransmission(MPU_ADDR);
  Wire.write(0x3B); // starting with register 0x3B (ACCEL_XOUT_H)
  Wire.endTransmission(false); // the parameter indicates that the Arduino will send a restart. As a result, the connection is kept active.
  Wire.requestFrom(MPU_ADDR, 7*2, true); // Total of 7*2=14 registers
  
  //Reading and storing two registers in the same variable for HIGH register and LOW register
  accelerometer_x = Wire.read()<<8 | Wire.read(); // reading registers: 0x3B (ACCEL_XOUT_H) and 0x3C (ACCEL_XOUT_L)
  accelerometer_y = Wire.read()<<8 | Wire.read(); // reading registers: 0x3D (ACCEL_YOUT_H) and 0x3E (ACCEL_YOUT_L)
  accelerometer_z = Wire.read()<<8 | Wire.read(); // reading registers: 0x3F (ACCEL_ZOUT_H) and 0x40 (ACCEL_ZOUT_L)
  temperature = Wire.read()<<8 | Wire.read(); // reading registers: 0x41 (TEMP_OUT_H) and 0x42 (TEMP_OUT_L)
  gyro_x = Wire.read()<<8 | Wire.read(); // reading registers: 0x43 (GYRO_XOUT_H) and 0x44 (GYRO_XOUT_L)
  gyro_y = Wire.read()<<8 | Wire.read(); // reading registers: 0x45 (GYRO_YOUT_H) and 0x46 (GYRO_YOUT_L)
  gyro_z = Wire.read()<<8 | Wire.read(); // reading registers: 0x47 (GYRO_ZOUT_H) and 0x48 (GYRO_ZOUT_L)
  step_captured_now = millis();

  //Checking for acceleration change in the z-axis. If there is change in the acceleration, then the step count increments
    if( accelerometer_z < 0 )
        flag = true;
    else if( flag == true && accelerometer_z> 0 )
    {
        flag = false;
        total_steps_taken = total_steps_taken+1;
    }
}


//Final readings of results
if(millis() - reading_captured_now > 500){
    float temp = bmp.readTemperature();
    float pressure = bmp.readPressure();
    float altitude = bmp.readAltitude();
    reading_captured_now = millis();
    
    total_temp_taken = total_temp_taken + temp;
    how_many_times_did_temp_get_recorded = how_many_times_did_temp_get_recorded + 1;
    
    total_pressure_taken = total_pressure_taken + pressure;
    how_many_times_did_pressure_get_recorded = how_many_times_did_pressure_get_recorded + 1;
    
    total_altitude_taken = total_altitude_taken + altitude;
    how_many_times_did_altitude_get_recorded = how_many_times_did_altitude_get_recorded + 1;
}

// After one minute has passed, the readings are displayed in a string (result_1) and the sound (result_2) is displayed in an array
 
millisCurrentmin = millis();
if(millisCurrentmin - millisLasmin >= minute1){
  millisLasmin = millisCurrentmin;
  int heart_beats_average = total_heart_beats/how_many_times_did_heart_beats_get_recorded;
  float average_temp = total_temp_taken / how_many_times_did_temp_get_recorded;
  float average_pressure_taken = total_pressure_taken / how_many_times_did_pressure_get_recorded;
  float average_altitude_taken = total_altitude_taken / how_many_times_did_altitude_get_recorded;
  String result_1 = "*\"heart\":" + String(heart_beats_average) + " ,\"steps\":" + String(total_steps_taken) + " ,\"temperature\":" + String(average_temp);


  String result_2 = ",\"Sound\":[";
  for (int i = 0;i<index_for_sampleBufferValue_array;i++){
      result_2 = result_2 +   String(sampleBufferValue_array[i]) ;
      
      if(i+1 != index_for_sampleBufferValue_array){
        result_2 = result_2 + ",";
      }
      
  }
  result_2 = result_2 + "];";
 Serial.println();
  Serial.print(result_1);
  Serial.print(result_2);
  
//Send to the Wi-Fi Module to print result 1 and 2
  espSerial.print(result_1);
  espSerial.print(result_2);

  //Reseting
  total_heart_beats=0;
  how_many_times_did_heart_beats_get_recorded=0;
  total_temp_taken=0;
  how_many_times_did_temp_get_recorded=0;
  total_pressure_taken=0;
  how_many_times_did_pressure_get_recorded=0;
  total_altitude_taken=0;
  how_many_times_did_altitude_get_recorded=0;
  total_steps_taken = 0;
  index_for_sampleBufferValue_array = 0;
    }

}
