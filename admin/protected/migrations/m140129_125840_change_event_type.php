<?php

class m140129_125840_change_event_type extends CDbMigration
{
    public function up()
    {
        $this->truncateTable('event');
        $this->alterColumn('event', 'type', 'tinyint(32) UNSIGNED NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('event', 'type', 'varchar(64) NOT NULL');
    }
}