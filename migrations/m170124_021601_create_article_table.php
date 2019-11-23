<?php

use yii\db\Migration;

/**
 * Class m170124_021601_create_article_table
 */
class m170124_021601_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


	 $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'content'=>$this->text(),
            'date'=>$this->date(),
            'image'=>$this->string(),
            'viewed'=>$this->integer(),
            'user_id'=>$this->integer(),
            'status'=>$this->integer(),
            'category_id'=>$this->integer(),
        ]);




        // creates index for column `user_id`
        $this->createIndex(
            'idx-posts-user_id',
            'article',
            'user_id'
        );


        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-posts-user_id',
            'article',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191122_101056_test cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_101056_test cannot be reverted.\n";

        return false;
    }
    */
}


