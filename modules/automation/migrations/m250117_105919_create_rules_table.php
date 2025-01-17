<?php

use yii\db\Migration;

class m250117_105919_create_rules_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%rules}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string('255')->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-rules-user-id',
            '{{%rules}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-rules-user_id',
            '{{%rules}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-rules-user_id',
            '{{%rules}}',
        );

        $this->dropTable('{{%rules}}');
    }
}
