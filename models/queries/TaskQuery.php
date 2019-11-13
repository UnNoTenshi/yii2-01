<?php

namespace app\models\queries;

use app\models\Task;

/**
 * This is the ActiveQuery class for [[\app\models\Task]].
 *
 * @see \app\models\Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byCreator($userId) {
      return $this->andWhere("[[task.creator_id]] = " . $userId);
    }
}
