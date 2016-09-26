<?php

class m151120_082010_change_mail_log_user_id_to_email extends CDbMigration
{
    public function up()
    {
        $this->dropTable('mail_log');
        $this->getDbConnection()->createCommand("
            CREATE TABLE `mail_log` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(64) NOT NULL,
              `email_template_id` int(11) NOT NULL,
              `options` text DEFAULT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_mail_log_email` (`email`),
              CONSTRAINT `fk_mail_log_email` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('mail_log');
        $this->getDbConnection()->createCommand("
            CREATE TABLE `mail_log` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `mail_id` int(11) NOT NULL,
              `options` text DEFAULT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_mail_log_user_id` (`user_id`),
              CONSTRAINT `fk_mail_log_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }
}