<?php

namespace app\controllers;

use app\models\Files;
use app\models\Films;
use app\models\FilmsSearch;
use app\models\Persons;
use app\models\PersonsSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FilmsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $searchModelPersons = new PersonsSearch();
        $dataProviderPersons = $searchModelPersons->search($this->request->queryParams);

        $year = (int) \Yii::$app->request->get('year', date('Y'));
        $top = Persons::getTop(['films.year' => $year], 10);
        $dataProviderTop = new ArrayDataProvider([
            'allModels' => $top,
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelPersons' => $searchModelPersons,
            'dataProviderPersons' => $dataProviderPersons,
            'dataProviderTop' => $dataProviderTop,
            'year' => $year,
        ]);
    }

}
