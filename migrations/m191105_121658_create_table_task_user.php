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

  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    echo "m191105_121658_create_table_task_user cannot be reverted.\n";

    return false;
  }

  public function up()
  {
    $this->createTable("task_user", [
      "id" => $this->primaryKey(),
      "task_id" => $this->integer()->notNull(),
      "user_id" => $this->integer()->notNull()
    ]);
  }

  public function down()
  {
    $this->dropTable("task_user");
  }
}
