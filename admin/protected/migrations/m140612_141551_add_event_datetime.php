<?php

class m140612_141551_add_event_datetime extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'datetime', 'datetime DEFAULT NULL');

        // Update old preferences
        $this->getDbConnection()->createCommand("
            UPDATE event SET datetime = timestamp
        ")->execute();
    }

    public function down()
    {
        $this->dropColumn('event', 'datetime');
    }
}