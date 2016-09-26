<?php

class m140604_130818_uk_artist_gig extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("
            CREATE TABLE artist_gig_update AS SELECT DISTINCT * FROM artist_gig GROUP BY artist_id, gig_id;
            DROP TABLE artist_gig;
            RENAME TABLE artist_gig_update TO artist_gig;
        ")->execute();

        $this->createIndex('uk_artist_gig', 'artist_gig', 'artist_id,gig_id', true);
    }

    public function down()
    {
        $this->dropIndex('uk_artist_gig', 'artist_gig');
    }
}