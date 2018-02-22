<?php

use yii\db\Migration;

/**
 * Class m180222_001751_createTableUrl
 */
class m180222_001751_createTableUrl extends Migration
{

    public function safeUp()
    {
        $this->createTable('url',[
            'id'=>$this->primaryKey(),
            'url'=>$this->string(255),
            'short_url'=>$this->string(20)->unique(),
            'date_create'=>$this->dateTime(),
        ]);
        $this->createIndex('ishort_url','url','short_url');
    }

    public function safeDown()
    {
        $this->dropTable('url');
    }

}
