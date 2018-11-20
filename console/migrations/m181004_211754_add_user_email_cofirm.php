<?php

use yii\db\Migration;

/**
 * Class m181004_211754_add_user_email_cofirm
 */
class m181004_211754_add_user_email_cofirm extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181004_211754_add_user_email_cofirm cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181004_211754_add_user_email_cofirm cannot be reverted.\n";

        return false;
    }
    */
}
