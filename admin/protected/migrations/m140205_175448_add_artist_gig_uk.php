<?php

class m140205_175448_add_artist_gig_uk extends CDbMigration
{
    public function up()
    {
        $this->createIndex('uk_artist_gig', 'artist_gig', 'artist_id,gig_id', true);
    }

    public function down()
    {
        $this->dropIndex('uk_artist_gig', 'artist_gig');
    }
}