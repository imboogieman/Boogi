<?php

class m131015_091143_venue_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `venue` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(64) NOT NULL,
              `description` text,
              `country_id` int(11) NOT NULL,
              `city` varchar(64) NOT NULL,
              `address` text NOT NULL,
              `latitude` float(10,6) DEFAULT NULL,
              `longitude` float(10,6) DEFAULT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_venue_country_id` (`country_id`),
              CONSTRAINT `fk_venue_country_id` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('venue');
    }
}
