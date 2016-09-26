<?php

class m131015_091036_artist_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `artist` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(255) DEFAULT NULL,
              `name` varchar(64) NOT NULL,
              `description` text,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('artist');
    }
}
