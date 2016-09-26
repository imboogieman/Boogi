<?php

class m131017_155226_venue_file extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `venue_file` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `venue_id` int(11) NOT NULL,
              `file_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_venue_file_venue_id` (`venue_id`),
              KEY `fk_venue_file_file_id` (`file_id`),
              CONSTRAINT `fk_venue_file_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_venue_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('venue_file');
    }
}