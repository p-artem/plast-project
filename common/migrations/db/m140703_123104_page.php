<?php

use yii\db\Migration;

class m140703_123104_page extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id'         => $this->primaryKey(),
            'parent_id'  => $this->integer(),
            'slug'       => $this->string(2048),
            'name'       => $this->string(255),
            'h1'         => $this->string(255),
            'text'       => $this->text(),
            'metatitle'  => $this->text(),
            'metakeys'   => $this->text(),
            'metadesc'   => $this->text(),
            'brief'      => $this->text(),
            'image'      => $this->string(),
            'icon'       => $this->string()->defaultValue(''),
            'view'       => $this->string()->defaultValue(''),
            'sorting'    => $this->smallInteger(5)->defaultValue(0),
            'status'     => $this->smallInteger(5)->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%page_menu}}', [
            'page_id' => $this->integer(),
            'menu_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-page_menu', '{{%page_menu}}', ['page_id', 'menu_id']);

        $this->createIndex('idx-page-parent_id', '{{%page}}', 'parent_id');

        $this->addForeignKey('fk-page-parent', '{{%page}}', 'parent_id', '{{%page}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('fk-page_menu-page', '{{%page_menu}}', 'page_id', '{{%page}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%page_menu}}');
        $this->dropTable('{{%page}}');
    }
}