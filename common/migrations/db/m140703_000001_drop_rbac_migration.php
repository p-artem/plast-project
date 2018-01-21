<?php

use yii\db\Migration;

class m140703_000001_drop_rbac_migration extends Migration
{
    public function up()
    {
//        $this->createTable('{{%system_rbac_migration}}', [
//        ]);
    }

    public function down()
    {
        $this->dropTable('{{%system_rbac_migration}}');
    }
}
