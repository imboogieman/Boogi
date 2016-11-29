<?php

class m140204_151751_artist_map_data_stored_proc extends CDbMigration
{
    public function up()
    {
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

    public function down()
    {
        $this->getDbConnection()->createCommand("
            DROP PROCEDURE `GET_ARTIST_MAP_DATA`;
        ")->execute();
    }
}