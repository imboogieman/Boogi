<?php

class m140524_115925_remove_artist_gig_uk extends CDbMigration
{
    public function up()
    {
        $this->dropIndex('uk_artist_gig', 'artist_gig');
    }

    public function down()
    {
        $this->createIndex('uk_artist_gig', 'artist_gig', 'artist_id,gig_id', true);
    }
}