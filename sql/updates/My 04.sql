alter table `realmlist` add column `Version` int (11) DEFAULT '243' NULL  after `WorldDatabaseInfo`;
alter table `realmlist` add column `WowdCharInfoLink` varchar (255)  NULL  after `Version`; 
