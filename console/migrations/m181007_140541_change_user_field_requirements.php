<?php

use yii\db\Migration;

/**
 * Class m181007_140541_change_user_field_requirements
 */
class m181007_140541_change_user_field_requirements extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'username', $this->string());
        $this->alterColumn('{{%user}}', 'password_hash', $this->string());
        $this->alterColumn('{{%user}}', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'username', $this->string()->notNull());
        $this->alterColumn('{{%user}}', 'password_hash', $this->string()->notNull());
        $this->alterColumn('{{%user}}', 'email', $this->string()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181007_140541_change_user_field_requirements cannot be reverted.\n";

        return false;
    }
    */
}
