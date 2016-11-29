<?php

class m140212_142025_email_queue_fields extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('event', 'email_status', 'tinyint(1) DEFAULT ' . Event::EMAIL_NOT_SENT);
        $this->addColumn('event', 'email_attempts', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        $this->alterColumn('event', 'email_status', 'int(11) DEFAULT NULL');
        $this->dropColumn('event', 'email_attempts');
    }
}