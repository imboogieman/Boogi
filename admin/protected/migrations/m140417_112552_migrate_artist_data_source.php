<?php

class m140417_112552_migrate_artist_data_source extends CDbMigration
{
    public function up()
    {
        $this->addColumn('artist', 'ds_type', 'tinyint(2) DEFAULT 0');

        // Update old preferences
        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::FACEBOOK ." WHERE data_provider = 'facebook'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::GIGATOOLS ." WHERE data_provider = 'gigatools'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::BANDPAGE ." WHERE data_provider = 'bandpage'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::BANDSINTOWN ." WHERE data_provider = 'bandsintown'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::SONGKICK ." WHERE data_provider = 'songkick'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::CROWDSURGE ." WHERE data_provider = 'crowdsurge'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::REVERBNATION ." WHERE data_provider = 'reverbnation'
        ")->execute();

        $this->getDbConnection()->createCommand("
            UPDATE artist SET ds_type = " .  DataSource::RESIDENTADVISOR ." WHERE data_provider = 'residentadvisor'
        ")->execute();
    }

    public function down()
    {
        $this->dropColumn('artist', 'ds_type');
    }
}