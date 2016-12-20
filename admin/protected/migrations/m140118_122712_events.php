<?php

class m140118_122712_events extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `event` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `type` varchar(64) NOT NULL,
              `init_type` varchar(64) NOT NULL,
              `init_id` int(11) NOT NULL,
              `target_type` varchar(64) NOT NULL,
              `target_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('event');
    }
}