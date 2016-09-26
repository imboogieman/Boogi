<?php

class m150722_143825_add_event_data extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'data', 'text DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('event', 'data');
    }
}