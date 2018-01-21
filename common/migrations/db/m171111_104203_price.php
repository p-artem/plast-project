<?php

use yii\db\Migration;

/**
 * Class m171111_104203_price
 */
class m171111_104203_price extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%price}}', [
            'id'         => $this->primaryKey(),
            'file'       => $this->string(),
            'sorting'    => $this->smallInteger()->defaultValue(0),
            'status'     => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%price}}');
    }
}
