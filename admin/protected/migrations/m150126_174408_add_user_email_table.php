<?php

class m150126_174408_add_user_email_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `user_email` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `radar_enabled` tinyint(1) NULL DEFAULT 1,
              `radar_last_sent` datetime DEFAULT NULL,
              `radar_options` varchar(255) DEFAULT NULL,
              `reply_enabled` tinyint(1) NULL DEFAULT 1,
              `reply_last_sent` datetime DEFAULT NULL,
              `reply_options` varchar(255) DEFAULT NULL,
              `retention_sent` tinyint(1) NULL DEFAULT 0,
              `retention_14_sent` tinyint(1) NULL DEFAULT 0,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_user_email_user_id` (`user_id`),
              CONSTRAINT `fk_user_email_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('user_email');
    }
}