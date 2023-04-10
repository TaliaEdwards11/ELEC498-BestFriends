
drop database bestfriends;


create database bestfriends;
Use bestfriends;

create table Owner(
	Username 	char(100) not null primary key,
	Password	char(100) not null, 
	Last_Name	varchar(20) not null,
	First_Name	varchar(20) not null
);

create table Dog(
	Name	varchar(20) not null,
	Dog_Type	varchar(20) not null,
	Dog_Size	varchar(20) not null,
	Age	int not null,
	Weight	int not null,
	Sensitivity	int not null,
	Address		varchar(50) not null,
	Owner_Username	char(100) not null,
	primary key(Owner_Username, Name),
	foreign key(Owner_Username) references Owner(Username)

);


create table Heart_Rate(
	HDate	date	not null,
	HTime	time not null,
	Heartbeatpm	Decimal(6,2) not null,
	Dog_Name	varchar(20) not null,
	Owner_UserName	char(100) not null,
	primary key(Owner_Username,Dog_Name, HDate, HTime),
	foreign key(Owner_Username) references Owner(Username)
	
);

create table Steps(
	HDate	date	not null,
	HTime	time not null,
	Stepspm	int not null,
	Dog_Name	varchar(20) not null,
	Owner_UserName	char(100) not null,
	primary key(Owner_Username,Dog_Name, HDate, HTime),
	foreign key(Owner_Username) references Owner(Username)
	
);

create table Temperature(
	HDate	date	not null,
	HTime	time not null,
	Temppm	Decimal(4,2) not null,
	Dog_Name	varchar(20) not null,
	Owner_UserName	char(100) not null,
	primary key(Owner_Username,Dog_Name, HDate, HTime),
	foreign key(Owner_Username) references Owner(Username)
	
);

create table Audio(
	HDate	date	not null,
	HTime	time not null,
	EntryNum int not null,
	Audio	int not null,
	Dog_Name	varchar(20) not null,
	Owner_UserName	char(100) not null,
	primary key(Owner_Username,Dog_Name, HDate, HTime, EntryNum),
	foreign key(Owner_Username) references Owner(Username)
	
);






insert into Owner values
('Billy123','Pa$$worb','Brady','Billy')
;


insert into Dog values
('Doguino','Border Colis','Medium', 5, 40, 3, '216 Colborne Street, Kingston ON, K7K1E3', 'Billy123')
;

insert into Heart_Rate values
('2023-01-08', '18:05:00', 50.02, 'Doguino', 'Billy123'),
('2023-01-08', '18:06:00', 45, 'Doguino', 'Billy123'),
('2023-01-08', '18:07:00', 60, 'Doguino', 'Billy123'),
('2023-01-08', '18:08:00', 70, 'Doguino', 'Billy123'),
('2023-01-08', '18:09:00', 55, 'Doguino', 'Billy123')
;

insert into Steps values
('2023-01-08', '18:05:00', 15, 'Doguino', 'Billy123'),
('2023-01-08', '18:06:00', 0, 'Doguino', 'Billy123'),
('2023-01-08', '18:07:00', 25, 'Doguino', 'Billy123'),
('2023-01-08', '18:08:00', 10, 'Doguino', 'Billy123'),
('2023-01-08', '18:09:00', 0, 'Doguino', 'Billy123')
;

insert into Temperature values
('2023-01-08', '18:05:00', 38.2, 'Doguino', 'Billy123'),
('2023-01-08', '18:06:00', 38.4, 'Doguino', 'Billy123'),
('2023-01-08', '18:07:00', 38.3, 'Doguino', 'Billy123'),
('2023-01-08', '18:08:00', 38.3, 'Doguino', 'Billy123'),
('2023-01-08', '18:09:00', 38.3, 'Doguino', 'Billy123')
;

insert into Audio values
('2023-01-08', '18:05:00', 1, 3, 'Doguino', 'Billy123'),
('2023-01-08', '18:06:00', 2, 4, 'Doguino', 'Billy123'),
('2023-01-08', '18:07:00', 3, 10, 'Doguino', 'Billy123'),
('2023-01-08', '18:08:00', 4, 8, 'Doguino', 'Billy123'),
('2023-01-08', '18:09:00', 5, 5, 'Doguino', 'Billy123')
;

