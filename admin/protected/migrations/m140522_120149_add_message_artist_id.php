<?php

class m140522_120149_add_message_artist_id extends CDbMigration
{
    public function up()
    {
        $this->addColumn('message', 'artist_id', 'int(11) NOT NULL');
        $this->addForeignKey('fk_message_artist_id', 'message', 'artist_id', 'artist', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('message', 'artist_id');
        $this->dropForeignKey('fk_message_artist_id', 'message');
    }
}