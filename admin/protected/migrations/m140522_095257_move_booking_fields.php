<?php

class m140522_095257_move_booking_fields extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist_gig', 'status', 'tinyint(1) DEFAULT 1');
        $this->dropColumn('gig', 'status');

        $this->addColumn('artist_gig', 'price', 'int(11) DEFAULT NULL');
        $this->dropColumn('gig', 'price');

        $this->addColumn('artist_gig', 'currency', 'tinyint(1) DEFAULT NULL');
        $this->dropColumn('gig', 'currency');

        $this->addColumn('artist_gig', 'accommodation', 'tinyint(1) DEFAULT NULL');
        $this->dropColumn('gig', 'accommodation');

        $this->addColumn('artist_gig', 'transfer', 'tinyint(1) DEFAULT NULL');
        $this->dropColumn('gig', 'transfer');

        $this->alterColumn('gig', 'capacity', 'tinyint(1) DEFAULT NULL');
        $this->alterColumn('gig', 'type', 'tinyint(1) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist_gig', 'status');
        $this->addColumn('gig', 'status', 'int(11) DEFAULT 0');

        $this->dropColumn('artist_gig', 'price');
        $this->addColumn('gig', 'price', 'int(11) DEFAULT 1');

        $this->dropColumn('artist_gig', 'currency');
        $this->addColumn('gig', 'currency', 'tinyint(1) DEFAULT 1');

        $this->dropColumn('artist_gig', 'accommodation');
        $this->addColumn('gig', 'accommodation', 'tinyint(1) DEFAULT 1');

        $this->dropColumn('artist_gig', 'transfer');
        $this->addColumn('gig', 'transfer', 'tinyint(1) DEFAULT 1');

        $this->alterColumn('gig', 'capacity', 'tinyint(1) DEFAULT 1');
        $this->alterColumn('gig', 'type', 'tinyint(1) DEFAULT 1');
    }
}