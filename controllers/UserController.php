<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionTest() {
      $user = new User();

      $user->setAttributes([
        "username" => "Student",
        "name" => "Sergey",
        "password_hash" => password_hash("qwerty", PASSWORD_BCRYPT),
        "creator_id" => 2,
        "created_at" => time()
      ]);

      $user->save();

      $firstTask = new Task();
      $firstTask->setAttributes([
        "title" => "Task 04",
        "description" => "This is task 04",
        "created_at" => time(),
      ]);

      $secondTask = new Task();
      $secondTask->setAttributes([
        "title" => "Task 05",
        "description" => "This is task 05",
        "created_at" => time(),
      ]);

      $thirdTask = new Task();
      $thirdTask->setAttributes([
        "title" => "Task 06",
        "description" => "This is task 06",
        "created_at" => time(),
      ]);

      $firstTask->link(Task::RELATION_CREATOR, $user);
      $secondTask->link(Task::RELATION_CREATOR, $user);
      $thirdTask->link(Task::RELATION_CREATOR, $user);

      VarDumper::dump(User::find()->with(User::RELATION_CREATED_TASK)->all(), 5, true);
      VarDumper::dump(User::find()->joinWith(User::RELATION_CREATED_TASK)->all(), 5, true);

      $fourthTask = new Task();
      $fourthTask->setAttributes([
        "title" => "Task 07",
        "description" => "This is task 07",
        "created_at" => time(),
      ]);

      $fourthTask->link(Task::RELATION_CREATOR, User::findOne(2));

      $fourthTask->link(Task::RELATION_ACCESSED_USERS, User::findOne(1));
      $fourthTask->link(Task::RELATION_ACCESSED_USERS, User::findOne(3));
      $fourthTask->link(Task::RELATION_ACCESSED_USERS, User::findOne(5));

      VarDumper::dump($fourthTask->accessedUsers, 5, true);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
