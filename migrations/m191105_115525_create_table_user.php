<?php

use yii\db\Migration;

/**
 * Class m191105_115525_create_table_user
 */
class m191105_115525_create_table_user extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable("user", [
      "id" => $this->primaryKey(),
      "username" => $this->string(255)->notNull(),
      "name" => $this->string(255)->notNull(),
      "password_hash" => $this->string(255)->notNull(),
      "access_token" => $this->string(255)->null(),
      "auth_key" => $this->string(255)->null(),
      "creator_id" => $this->integer()->notNull(),
      "updater_id" => $this->integer()->null(),
      "created_at" => $this->integer()->notNull(),
      "updated_at" => $this->integer()->null()
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable("user");
  }

  /*public function up()
  {

  }

  public function down()
  {

  }*/
}
