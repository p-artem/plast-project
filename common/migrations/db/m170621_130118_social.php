<?php

use yii\db\Migration;

class m170621_130118_social extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%social}}', [
            'id'      => $this->primaryKey(),
            'name'    => $this->string()->notNull(),
            'link'    => $this->string()->notNull(),
            'image'   => $this->string(),
            'sorting' => $this->smallInteger()->notNull()->defaultValue(0),
            'status'  => $this->boolean()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%social}}');
    }
}
