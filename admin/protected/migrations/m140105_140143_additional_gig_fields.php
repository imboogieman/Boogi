<?php

class m140105_140143_additional_gig_fields extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'from_venue_id', 'int(11) DEFAULT NULL');
        $this->addColumn('gig', 'capacity', 'tinyint(1) DEFAULT 1');
        $this->addColumn('gig', 'type', 'tinyint(1) DEFAULT 1');
        $this->addColumn('gig', 'accommodation', 'tinyint(1) DEFAULT 1');
        $this->addColumn('gig', 'transfer', 'tinyint(1) DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('gig', 'from_venue_id');
        $this->dropColumn('gig', 'capacity');
        $this->dropColumn('gig', 'type');
        $this->dropColumn('gig', 'accommodation');
        $this->dropColumn('gig', 'transfer');
    }
}