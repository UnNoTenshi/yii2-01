<?php

use yii\db\Migration;

/**
 * Class m191106_093733_fk_user_taskuser_task
 */
class m191106_093733_fk_user_taskuser_task extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->addForeignKey("fk_taskuser_user", "task_user", ["user_id"], "user", ["id"]);
    $this->addForeignKey("fk_taskuser_task", "task_user", ["task_id"], "task", ["id"]);
    $this->addForeignKey("fk_task_user_creator", "task", ["creator_id"], "user", ["id"]);
    $this->addForeignKey("fk_task_user_updater", "task", ["updater_id"], "user", ["id"]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropForeignKey("fk_task_user_updater", "task");
    $this->dropForeignKey("fk_task_user_creator", "task");
    $this->dropForeignKey("fk_taskuser_task", "task_user");
    $this->dropForeignKey("fk_taskuser_user", "task_user");
  }

  /*public function up()
  {

  }

  public function down()
  {

  }*/
}
