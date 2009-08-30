alter table `realmlist` add column `cloneid` int(11)  DEFAULT '-1' NOT NULL after `WowdCharInfoLink`;
alter table `realmlist` add column `raport` int(11) DEFAULT '3443' NOT NULL after `cloneid`;
