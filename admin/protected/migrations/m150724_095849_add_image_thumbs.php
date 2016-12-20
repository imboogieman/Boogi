<?php

class m150724_095849_add_image_thumbs extends CDbMigration
{
    public function up()
    {
        $this->addColumn('file', 'crop', 'varchar(255) DEFAULT NULL');
        $this->addColumn('file', 'thumb', 'varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('file', 'crop');
        $this->dropColumn('file', 'thumb');
    }
}