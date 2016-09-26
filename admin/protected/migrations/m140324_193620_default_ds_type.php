<?php

class m140324_193620_default_ds_type extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('gig', 'ds_type', 'tinyint(2) DEFAULT 0');
        $this->alterColumn('venue', 'ds_type', 'tinyint(2) DEFAULT 0');
    }

    public function down()
    {
        $this->alterColumn('gig', 'ds_type', 'tinyint(2) DEFAULT NULL');
        $this->alterColumn('venue', 'ds_type', 'tinyint(2) DEFAULT NULL');
    }
}