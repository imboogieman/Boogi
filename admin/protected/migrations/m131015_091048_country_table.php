<?php

class m131015_091048_country_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `country` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(64) NOT NULL,
              `iso2` varchar(2) NOT NULL,
              `iso3` varchar(3) NOT NULL,
              `numeric` int(3) unsigned NOT NULL,
              `standart` varchar(16) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('country');
    }
}
