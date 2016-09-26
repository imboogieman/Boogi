<?php

class m140416_103511_add_new_contact_form extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `contact` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(255) DEFAULT NULL,
              `name` varchar(64) NOT NULL,
              `message` text,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('contact');
    }
}