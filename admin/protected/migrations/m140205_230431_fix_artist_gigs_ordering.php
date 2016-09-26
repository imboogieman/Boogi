<?php

class m140205_230431_fix_artist_gigs_ordering extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            DROP PROCEDURE IF EXISTS `GET_ARTIST_MAP_DATA`;
        ")->execute();

        $this->getDbConnection()->createCommand("
            CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_ARTIST_MAP_DATA`(IN `_id` int)
            BEGIN
                SELECT g.datetime, g.`name`, v.`name` as venue, v.latitude, v.longitude
                FROM artist_gig ag
                JOIN gig g ON g.id = ag.gig_id
                JOIN venue v ON v.id = g.venue_id
                WHERE ag.artist_id = _id
                ORDER BY g.datetime ASC;
            END
        ")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand("
            DROP PROCEDURE `GET_ARTIST_MAP_DATA`;
        ")->execute();

        $this->getDbConnection()->createCommand("
            CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_ARTIST_MAP_DATA`(IN `_id` int)
            BEGIN
                SELECT g.datetime, g.`name`, v.`name` as venue, v.latitude, v.longitude
                FROM artist_gig ag
                JOIN gig g ON g.id = ag.gig_id
                JOIN venue v ON v.id = g.venue_id
                WHERE ag.artist_id = _id;
            END
        ")->execute();
    }
}