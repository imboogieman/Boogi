<?php

class m131015_091100_user_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `user` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(64) NOT NULL,
              `password` varchar(32) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
