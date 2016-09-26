<?php

class m140123_193919_gig_description extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'description', 'text DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('gig', 'description');
    }
}