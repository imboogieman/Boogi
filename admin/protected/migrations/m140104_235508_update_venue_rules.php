<?php

class m140104_235508_update_venue_rules extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('venue', 'name', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('venue', 'country_id', 'int(11) DEFAULT NULL');
        $this->alterColumn('venue', 'city', 'varchar(64) DEFAULT NULL');
        $this->alterColumn('venue', 'address', 'text DEFAULT NULL');
    }

    public function down()
    {
        $this->alterColumn('venue', 'name', 'varchar(64) NOT NULL');
        $this->alterColumn('venue', 'country_id', 'int(11) NOT NULL');
        $this->alterColumn('venue', 'city', 'varchar(64) NOT NULL');
        $this->alterColumn('venue', 'address', 'text NOT NULL');
    }
}