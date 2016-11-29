<?php

class m150210_102645_add_mailchimp_templates_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `mailchimp_template` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `source_id` int(11) NOT NULL,
              `folder_id` int(11) NOT NULL,
              `name` varchar(64) NOT NULL,
              `category` varchar(64) DEFAULT NULL,
              `layout` varchar(64) DEFAULT NULL,
              `preview_image` varchar(255) DEFAULT NULL,
              `date_created` datetime DEFAULT NULL,
              `active` tinyint(1) NULL DEFAULT 0,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('mailchimp_template');
    }
}