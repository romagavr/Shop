<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_network}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m181006_102930_create_user_network_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_network}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'identity' => $this->string()->notNull(),
            'network' => $this->string(16)->notNull(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_network-identity-name}}',
            '{{%user_network}}',
            ['identity','network'],
            true
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_network-user_id}}',
            '{{%user_network}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_network-user_id}}',
            '{{%user_network}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_network-user_id}}',
            '{{%user_network}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_network-user_id}}',
            '{{%user_network}}'
        );

        $this->dropTable('{{%user_network}}');
    }
}
