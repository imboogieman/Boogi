<?php

class m140612_113736_add_event_delete_status extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'status', 'tinyint(1) DEFAULT 1 AFTER `type`');
    }

    public function down()
    {
        $this->dropColumn('event', 'status');
    }
}