<?php

class m140411_103628_messaging extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `message` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `gig_id` int(11) NOT NULL,
              `type` tinyint(1) NOT NULL,
              `message` text,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_message_gig_id` (`gig_id`),
              CONSTRAINT `fk_message_gig_id` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('message');
    }
}