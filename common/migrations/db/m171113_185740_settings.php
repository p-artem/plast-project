<?php

use yii\db\Migration;

/**
 * Class m171113_185740_settings
 */
class m171113_185740_settings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            $tableOptions = 'ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id'           => $this->primaryKey(),
            'name'         => $this->string(),
            'short'        => $this->text(),
            'text'         => $this->text(),
            'logo'         => $this->string(),
            'main_image'   => $this->string(),
            'price'        => $this->string(),
            'main_phone'   => $this->string(),
            'phone'        => $this->string(),
            'email'        => $this->string(),
            'main_email'   => $this->string(),
            'address'      => $this->text(),
            'google_location' => $this->string(512),
            'coordinate_x' => $this->string(),
            'coordinate_y' => $this->string(),
            'status_site'  => $this->integer(1)->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}
