<?php

class m150211_110914_add_mandrill_templates_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `mandrill_template` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `slug` varchar(64) NOT NULL,
              `name` varchar(64) NOT NULL,
              `labels` varchar(64) DEFAULT NULL,
              `code` text DEFAULT NULL,
              `subject` varchar(64) DEFAULT NULL,
              `from_email` varchar(64) DEFAULT NULL,
              `from_name` varchar(64) DEFAULT NULL,
              `text` text DEFAULT NULL,
              `publish_name` varchar(64) DEFAULT NULL,
              `publish_code` text DEFAULT NULL,
              `publish_subject` varchar(64) DEFAULT NULL,
              `publish_from_email` varchar(64) DEFAULT NULL,
              `publish_from_name` varchar(64) DEFAULT NULL,
              `publish_text` text DEFAULT NULL,
              `published_at` datetime DEFAULT NULL,
              `created_at` datetime DEFAULT NULL,
              `updated_at` datetime DEFAULT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('mandrill_template');
    }
}