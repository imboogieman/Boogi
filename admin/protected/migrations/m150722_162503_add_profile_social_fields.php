<?php

class m150722_162503_add_profile_social_fields extends CDbMigration
{
    public function up()
    {
        $this->addColumn('promoter', 'address', 'varchar(255) DEFAULT NULL');
        $this->addColumn('promoter', 'facebook', 'varchar(255) DEFAULT NULL');
        $this->addColumn('promoter', 'facebook_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('promoter', 'twitter', 'varchar(255) DEFAULT NULL');
        $this->addColumn('promoter', 'twitter_name', 'varchar(255) DEFAULT NULL');
        $this->addColumn('promoter', 'homepage', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('promoter', 'address');
        $this->dropColumn('promoter', 'facebook');
        $this->dropColumn('promoter', 'facebook_name');
        $this->dropColumn('promoter', 'twitter');
        $this->dropColumn('promoter', 'twitter_name');
        $this->dropColumn('promoter', 'homepage');
    }
}