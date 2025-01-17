<?php

namespace app\modules\user\migrations;

use yii\db\Migration;

class m250114_065754_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}