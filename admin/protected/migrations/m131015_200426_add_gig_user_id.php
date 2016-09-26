<?php

class m131015_200426_add_gig_user_id extends CDbMigration
{
    public function up()
    {
        $this->addColumn('gig', 'user_id', 'int(11) NOT NULL AFTER `id`');
    }

    public function down()
    {
        $this->dropColumn('gig', 'user_id');
    }
}