<?php

class m140114_111818_artist_promoter_table extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `artist_promoter` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `artist_id` int(11) NOT NULL,
              `promoter_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_artist_promoter_artist_id` (`artist_id`),
              KEY `fk_artist_promoter_promoter_id` (`promoter_id`),
              CONSTRAINT `fk_artist_promoter_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_artist_promoter_promoter_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('artist_promoter');
    }
}