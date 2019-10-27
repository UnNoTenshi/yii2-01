<?php

namespace app\models;

use Yii;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $created_at
 */
class Product extends \yii\db\ActiveRecord
{
  const SCENARIO_DEFAULT = "default";
  const SCENARIO_CREATE = "create";
  const SCENARIO_UPDATE = "update";

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'product';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["name"], "filter", "filter" => function ($value) {
        return trim(strip_tags($value));
      }],
      [["name"], "string", "max" => 20],
      [["name", "price", "created_at"], RequiredValidator::class],
      [["created_at"], "integer"],
      ["price", function($attribute, $params) {
        if ($this->$attribute <= 0) {
          $this->addError($attribute, "Цена должна быть больше нуля");
        } else if ($this->$attribute > 1000) {
          $this->addError($attribute, "Цена должна быть меньше 1000");
        }
      }],
      [["created_at"], "default", "value" => function($model, $attribute) {
        return time();
      }]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'name' => 'Name',
      'price' => 'Price',
      'created_at' => 'Created At',
    ];
  }

  public function scenarios()
  {
    return [
      self::SCENARIO_DEFAULT => ["name"],
      self::SCENARIO_CREATE => ["name", "price"],
      self::SCENARIO_UPDATE => ["price", "created_at"]
    ];
  }
}
