<?php

class m131118_200550_subscription_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `subscription` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(255) DEFAULT NULL,
              `name` varchar(64) NOT NULL,
              `type` tinyint(1) DEFAULT 0,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('subscription');
    }
}