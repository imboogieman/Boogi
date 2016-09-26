<?php

class m140105_143937_add_ds_type extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'ds_type', 'tinyint(2) DEFAULT NULL');
        $this->addColumn('venue', 'ds_type', 'tinyint(2) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('gig', 'ds_type');
        $this->dropColumn('venue', 'ds_type');
    }
}