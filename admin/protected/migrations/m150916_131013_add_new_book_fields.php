<?php

class m150916_131013_add_new_book_fields extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist_gig', 'datetime_from', 'datetime DEFAULT NULL');
        $this->addColumn('artist_gig', 'datetime_to', 'datetime DEFAULT NULL');
        $this->addColumn('artist_gig', 'timezone', 'varchar(32) DEFAULT NULL');
        $this->addColumn('artist_gig', 'revenue_share', 'int(11) DEFAULT NULL');
        $this->alterColumn('artist_gig', 'price', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist_gig', 'datetime_from');
        $this->dropColumn('artist_gig', 'datetime_to');
        $this->dropColumn('artist_gig', 'timezone');
        $this->dropColumn('artist_gig', 'revenue_share');
        $this->alterColumn('artist_gig', 'price', 'int(11) DEFAULT NULL');
    }
}