<?php

use yii\db\Migration;

/**
 * Class m181004_214017_add_user_email_confirm
 */
class m181004_214017_add_user_email_confirm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{user}}', 'email_confirm_token');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181004_214017_add_user_email_confirm cannot be reverted.\n";

        return false;
    }
    */
}
