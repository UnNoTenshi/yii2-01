<?php

use yii\db\Migration;

/**
 * Class m191105_121644_create_table_task
 */
class m191105_121644_create_table_task extends Migration
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
    echo "m191105_121644_create_table_task cannot be reverted.\n";

    return false;
  }

  public function up()
  {
    $this->createTable("task", [
      "id" => $this->primaryKey(),
      "title" => $this->string(255)->notNull(),
      "description" => $this->text(),
      "creator_id" => $this->integer()->notNull(),
      "updater_id" => $this->integer()->null(),
      "created_at" => $this->integer()->notNull(),
      "updated_at" => $this->integer()->null()
    ]);
  }

  public function down()
  {
    $this->dropTable("task");
  }
}
