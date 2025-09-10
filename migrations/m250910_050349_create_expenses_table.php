<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expenses}}`.
 */
class m250910_050349_create_expenses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%expenses}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'description' => $this->string()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'date' => $this->date()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk_expenses_user_id', '{{%expenses}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_expenses_category_id', '{{%expenses}}', 'category_id', '{{%categories}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_expenses_category_id', '{{%expenses}}');
        $this->dropForeignKey('fk_expenses_user_id', '{{%expenses}}');
        $this->dropTable('{{%expenses}}');
    }
}
