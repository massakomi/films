<?php

namespace app\controllers;

use app\models\FilmsSearch;
use app\models\Persons;
use app\models\PersonsSearch;
use app\models\Subsribes;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonsController implements the CRUD actions for Persons model.
 */
class PersonsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete', 'subscribe'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['create', 'update','delete'],
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['subscribe'],
                            'roles' => ['?'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Persons models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PersonsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Persons model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $model = new FilmsSearch();
        $filmsProvider = $model->search(['person_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'filmsProvider' => $filmsProvider,
        ]);
    }

    /**
     * Creates a new Persons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Persons();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Persons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Persons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionSubscribe(int $id)
    {
        $model = new Subsribes();
        $model->person_id = $id;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Спасибо за подписку!');
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('subscribe', [
            'model' => $model,
            'session' => \Yii::$app->session,
        ]);
    }

    /**
     * Finds the Persons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Persons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Persons::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
