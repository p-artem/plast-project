<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contact`.
 */
class m161221_081009_contact extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%contact}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->notNull(),
            'surname'    =>$this->string(),
            'phone'      => $this->string(),
            'email'      => $this->string()->notNull(),
            'time'       => $this->string(),
            'message'    => $this->text()->notNull(),
            'subject'    => $this->string(),
            'type'       => $this->smallInteger()->notNull(),
            'status'     => $this->boolean()->notNull(),
            'created_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%contact}}');
    }
}