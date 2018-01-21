<?php

use yii\db\Migration;

/**
 * Class m171113_181936_slider
 */
class m171113_181936_slider extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%slider}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(),
            'text'       => $this->text(),
            'image'      => $this->string(),
            'position'   => $this->string(),
            'on_main'    => $this->string(),
            'sorting'    => $this->smallInteger()->defaultValue(0),
            'status'     => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%slider}}');
    }
}
