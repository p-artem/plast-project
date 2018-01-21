<?php

use common\models\User;
use yii\db\Migration;

class m140703_123000_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string(32),
            'email'                => $this->string()->notNull(),
            'phone'                => $this->string(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at'           => $this->integer(),
            'updated_at'           => $this->integer(),
            'logged_at'            => $this->integer(),
            'password_hash'        => $this->string()->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'access_token'         => $this->string(40)->notNull(),
            'oauth_client'         => $this->string(),
            'oauth_client_user_id' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%user_profile}}', [
            'user_id'    => $this->primaryKey(),
            'birthday'   => $this->date(),
            'city'       => $this->string(),
            'firstname'  => $this->string(),
            'middlename' => $this->string(),
            'lastname'   => $this->string(),
            'avatar'     => $this->string(),
            'locale'     => $this->string(32),
            'gender'     => $this->boolean()->defaultValue(1),
            'position'   => $this->string()
        ], $tableOptions);

        $this->addForeignKey('fk_user_profile', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_profile', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}