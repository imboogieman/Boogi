<?php

class m131230_123720_venue_ds_id extends CDbMigration
{
    public function up()
    {
        $this->addColumn('venue', 'ds_id', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('venue', 'ds_id');
    }
}