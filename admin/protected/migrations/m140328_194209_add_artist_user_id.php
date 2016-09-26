<?php

class m140328_194209_add_artist_user_id extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'user_id', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('artist', 'user_id');
    }
}