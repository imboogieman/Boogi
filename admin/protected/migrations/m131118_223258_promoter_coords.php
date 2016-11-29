<?php

class m131118_223258_promoter_coords extends CDbMigration
{
    public function up()
    {
        $this->addColumn('promoter', 'latitude', 'float(10,6) DEFAULT NULL');
        $this->addColumn('promoter', 'longitude', 'float(10,6) DEFAULT NULL');
        $this->addColumn('promoter', 'radius', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('promoter', 'latitude');
        $this->dropColumn('promoter', 'longitude');
        $this->dropColumn('promoter', 'radius');
    }
}