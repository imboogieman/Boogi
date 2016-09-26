<?php

class m131015_200708_add_gig_user_fk extends CDbMigration
{
    public function up()
    {
        $this->addForeignKey('fk_gig_user_id', 'gig', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_gig_user_id', 'gig');
    }
}