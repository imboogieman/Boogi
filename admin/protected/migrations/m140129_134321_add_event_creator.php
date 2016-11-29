<?php

class m140129_134321_add_event_creator extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'creator_id', 'int(11) DEFAULT NULL');
        $this->addColumn('event', 'creator_type', 'varchar(64) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('event', 'creator_id');
        $this->dropColumn('event', 'creator_type');
    }
}