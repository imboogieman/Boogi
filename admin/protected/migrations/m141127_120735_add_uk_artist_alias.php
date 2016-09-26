<?php

class m141127_120735_add_uk_artist_alias extends CDbMigration
{
    public function up()
    {
        $this->createIndex('uk_artist_alias', 'artist', 'alias', true);
    }

    public function down()
    {
        $this->dropIndex('uk_artist_alias', 'artist');
    }
}