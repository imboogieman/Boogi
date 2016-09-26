<?php

class m131017_162014_gig_file extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `gig_file` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `gig_id` int(11) NOT NULL,
              `file_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_gig_file_gig_id` (`gig_id`),
              KEY `fk_gig_file_file_id` (`file_id`),
              CONSTRAINT `fk_gig_file_gig_id` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_gig_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('gig_file');
    }
}