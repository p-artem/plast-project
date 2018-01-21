<?php

use yii\db\Migration;

class m170516_144836_product extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id'            => $this->primaryKey(),
            'category_id'   => $this->integer(),
            'slug'          => $this->string(2048),
            'name'          => $this->string(512),
            'text'          => $this->text(),
            'short'         => $this->text(),
            'location'      => $this->text(),
            'function'      => $this->text(),
            'size'          => $this->text(),
            'state'         => $this->text(),
            'architects'    => $this->text(),
            'clients'       => $this->text(),
            'collaboration' => $this->text(),
            'metatitle'     => $this->text(),
            'metakeys'      => $this->text(),
            'metadesc'      => $this->text(),
            'image'         => $this->string(255),
            'image_slider'  => $this->string(255),
            'status'        => $this->integer(1)->defaultValue(0),
            'on_main'       => $this->integer(1)->defaultValue(0),
            'sorting'       => $this->smallInteger()->defaultValue(0),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%product_category}}', [
            'id'          => $this->primaryKey(),
            'slug'        => $this->string(2048),
            'name'        => $this->text(),
            'description' => $this->text(),
            'metatitle'   => $this->text(),
            'metakeys'    => $this->text(),
            'metadesc'    => $this->text(),
            'sorting'     => $this->smallInteger()->defaultValue(0),
            'status'      => $this->integer(1)->defaultValue(0),
            'type'        => $this->integer(1),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_project', '{{%product}}', 'category_id', '{{%product_category}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk_project', '{{%product}}');

        $this->dropTable('{{%product_category}}');
        $this->dropTable('{{%product}}');
    }
}