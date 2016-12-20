<?php

class m131022_202014_add_artist_gig_relation extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE `artist_gig` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `artist_id` int(11) NOT NULL,
              `gig_id` int(11) NOT NULL,
              `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `fk_artist_gig_artist_id` (`artist_id`),
              KEY `fk_artist_gig_gig_id` (`gig_id`),
              CONSTRAINT `fk_artist_gig_gig_id` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_artist_gig_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")->execute();
    }

    public function down()
    {
        $this->dropTable('artist_gig');
    }
}