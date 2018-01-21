<?php

use yii\db\Migration;

/**
 * Class m150318_154933_gallery_ext
 */
class m150318_154933_gallery_ext extends Migration
{
     public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%gallery_image}}', [
            'id'          => $this->primaryKey(),
            'type'        => $this->string(255),
            'ownerId'     => $this->integer()->notNull(),
            'rank'        => $this->integer()->notNull()->defaultValue(0),
            'name'        => $this->string(255),
            'description' => $this->text(),
            'vertical'    => $this->smallInteger(5)->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%gallery_image}}');
    }
}