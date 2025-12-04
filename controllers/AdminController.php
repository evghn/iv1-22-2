<?php

namespace app\controllers;

use app\models\Application;
use app\models\AdminSearch;
use app\models\Status;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * AdminController implements the CRUD actions for Application model.
 */
class AdminController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->identity?->isAdmin) {
            return $this->redirect('/');
        }

        return true; // or false to not run the action
    }

    /**
     * Lists all Application models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param int $id №
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id №
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTodo($id)
    {
        $model = $this->findModel($id);

        if ($model) {
            $model->status_id = Status::getStausId('todo');
            if (!$model->save(false)) {
                VarDumper::dump($model->errors, 10, true);
                die;
            }

            Yii::$app->session->setFlash("toast", ["status" => "info", "text" => "Статус заявки №$model->id изменен на " . Status::getStatuses()[$model->status_id]]);
        }

        return $this->actionIndex();
    }


    public function actionReset($id)
    {
        $model = $this->findModel($id);


        $model->status_id = Status::getStausId('new');
        if ($model->save(false)) {
            return $this->actionIndex();
        } else {
            VarDumper::dump($model->errors, 10, true);
            die;
        }
    }


    public function actionFinally($id)
    {
        $model = $this->findModel($id);

        if ($model) {
            $model->status_id = Status::getStausId('finally');

            if (!$model->save(false)) {
                VarDumper::dump($model->errors, 10, true);
                die;
            }

            Yii::$app->session->setFlash("toast", ["status" => "success", "text" => "Статус заявки №$model->id изменен на " . Status::getStatuses()[$model->status_id]]);
        }

        return $this->actionIndex();
    }


    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);

        if ($model) {
            $model->status_id = Status::getStausId($status);

            if (!$model->save(false)) {
                VarDumper::dump($model->errors, 10, true);
                die;
            }

            Yii::$app->session->setFlash("toast", ["status" => "info", "text" => "Статус заявки №$model->id изменен на " . Status::getStatuses()[$model->status_id]]);
        }

        return $this->actionIndex();
    }

    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id №
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
