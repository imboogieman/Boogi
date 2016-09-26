<?php

class m150916_131004_add_new_gig_fields extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'datetime_from', 'datetime DEFAULT NULL');
        $this->addColumn('gig', 'datetime_to', 'datetime DEFAULT NULL');
        $this->addColumn('gig', 'timezone', 'varchar(32) DEFAULT NULL');
        $this->addColumn('gig', 'address', 'varchar(255) DEFAULT NULL');
        $this->addColumn('gig', 'price', 'int(11) DEFAULT NULL');
        $this->addColumn('gig', 'currency', 'tinyint(1) DEFAULT NULL');
        $this->alterColumn('gig', 'capacity', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('gig', 'datetime_from');
        $this->dropColumn('gig', 'datetime_to');
        $this->dropColumn('gig', 'timezone');
        $this->dropColumn('gig', 'address');
        $this->dropColumn('gig', 'ticket_price');
        $this->alterColumn('gig', 'capacity', 'tinyint(1) DEFAULT NULL');
    }
}