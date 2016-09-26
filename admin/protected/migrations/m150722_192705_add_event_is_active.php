<?php

class m150722_192705_add_event_is_active extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'is_active', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('event', 'is_active');
    }
}