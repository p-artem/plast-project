<?php

use yii\db\Migration;

class m999999_999999_load_dump extends Migration
{
    public function up()
    {
        $path = __DIR__ . '/dump.sql';

//        $this->execute(file_get_contents($path));
        echo "    > execute SQL: " . $path . " ...";
        $time = microtime(true);
       // $this->db->createCommand(file_get_contents($path))->execute();
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    public function down()
    {
        return true;
    }
}
