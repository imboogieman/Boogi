<?php

class m140129_140943_event_send_status extends CDbMigration
{
    public function up()
    {
        $this->addColumn('event', 'email_status', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('event', 'email_status');
    }
}