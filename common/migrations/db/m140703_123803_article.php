<?php

use yii\db\Migration;

class m140703_123803_article extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%article_category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(512),
            'parent_id' => $this->integer(),
            'name' => $this->string(512),
            'text' => $this->text(),
            'metatitle' => $this->text(),
            'metakeys' => $this->text(),
            'metadesc' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'sorting' => $this->smallInteger()->defaultValue(0),
            'status' => $this->boolean()->defaultValue(0),
            'popular' => $this->boolean()->defaultValue(0),
        ], $tableOptions);


        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(512),
            'category_id' => $this->integer(),
            'name' => $this->string(512),
            'text' => $this->text(),
            'short' => $this->text(),
            'tags' => $this->string(),
            'metatitle' => $this->text(),
            'metakeys' => $this->text(),
            'metadesc' => $this->text(),
            'image' => $this->string(),
            'video' => $this->text(),
            'view' => $this->string(),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'published_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->boolean()->defaultValue(0),
        ], $tableOptions);


        $this->addForeignKey('fk_article_author', '{{%article}}', 'created_by', '{{%user}}', 'id', 'restrict', 'cascade');
        $this->addForeignKey('fk_article_updater', '{{%article}}', 'updated_by', '{{%user}}', 'id', 'set null', 'cascade');
        $this->addForeignKey('fk_article_category', '{{%article}}', 'category_id', '{{%article_category}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_category_section', '{{%article_category}}', 'parent_id', '{{%article_category}}', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_article_author', '{{%article}}');
        $this->dropForeignKey('fk_article_updater', '{{%article}}');
        $this->dropForeignKey('fk_article_category', '{{%article}}');
        $this->dropForeignKey('fk_article_category_section', '{{%article_category}}');

        $this->dropTable('{{%article}}');
        $this->dropTable('{{%article_category}}');
    }
}