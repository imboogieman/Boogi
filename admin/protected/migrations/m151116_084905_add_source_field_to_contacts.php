<?php

class m151116_084905_add_source_field_to_contacts extends CDbMigration
{
    public function up()
    {
        $this->addColumn('contact', 'source', "varchar(32) DEFAULT 'contact'");
    }

    public function down()
    {
        $this->dropColumn('contact', 'source');
    }
}