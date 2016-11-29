<?php

class m140604_141529_add_bandpage_artist_id extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'bp_id', 'bigint(20) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('artist', 'bp_id');
    }
}