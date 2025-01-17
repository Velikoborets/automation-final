<?php

use yii\db\Migration;

class m250117_070701_create_conditions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%conditions}}', [
            'id' => $this->primaryKey(),
            'field' => $this->integer()->notNull(),
            'operator' => $this->string(10)->notNull(),
            'rule_id' => $this->integer()->notNull(),
            'value' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->notNull(),
        ]);

        $this->createIndex(
            'idx-conditions-rule_id',
            '{{%conditions}}',
            'rule_id'
        );

        $this->addForeignKey(
            'fk-conditions-rule_id',
            '{{%conditions}}',
            'rule_id',
            '{{%rules}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-conditions-rule_id',
            '{{%conditions}}'
        );

        $this->dropIndex(
            'idx-conditions-rule_id',
            '{{%conditions}}'
        );

        $this->dropTable('{{%conditions}}');
    }
}
