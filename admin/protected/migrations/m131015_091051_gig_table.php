<?php

class m131015_091051_gig_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `gig` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `venue_id` int(11) NOT NULL,
              `name` varchar(64) DEFAULT NULL,
              `datetime` datetime NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('gig');
    }
}
