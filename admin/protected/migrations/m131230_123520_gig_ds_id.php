<?php

class m131230_123520_gig_ds_id extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'ds_id', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist', 'ds_id');
    }
}