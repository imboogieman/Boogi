<?php

class m140408_124510_remove_artist_email extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('artist', 'email');
    }

    public function down()
    {
        $this->addColumn('artist', 'email', 'varchar(255) DEFAULT NULL');
    }
}