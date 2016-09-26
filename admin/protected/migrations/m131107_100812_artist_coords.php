<?php

class m131107_100812_artist_coords extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'latitude', 'float(10,6) DEFAULT NULL');
        $this->addColumn('artist', 'longitude', 'float(10,6) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist', 'latitude');
        $this->dropColumn('artist', 'longitude');
    }
}