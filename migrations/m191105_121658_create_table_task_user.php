<?php

use yii\db\Migration;

/**
 * Class m191105_121658_create_table_task_user
 */
class m191105_121658_create_table_task_user extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable("task_user", [
      "id" => $this->primaryKey(),
      "task_id" => $this->integer()->notNull(),
      "user_id" => $this->integer()->notNull()
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable("task_user");
  }

  /*public function up()
  {

  }

  public function down()
  {

  }*/
}
