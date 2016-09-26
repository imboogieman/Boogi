<?php

class m150129_140147_add_paypal_payment_info extends CDbMigration
{
    public function up()
    {
        $this->addColumn('user', 'plan_payment_info', 'text DEFAULT NULL AFTER plan_activated');
    }

    public function down()
    {
        $this->dropColumn('user', 'plan_payment_info');
    }
}