<?php

class m131015_111251_artist_file extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `artist_file` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `artist_id` int(11) NOT NULL,
              `file_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_artist_file_artist_id` (`artist_id`),
              KEY `fk_artist_file_file_id` (`file_id`),
              CONSTRAINT `fk_artist_file_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_artist_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('artist_file');
    }
}
