<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\Food;
use app\models\Ingredient;

/**
 * FoodController implements the CRUD actions for Food model.
 */
class FoodController extends MainController
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

    /**
     * Lists all Food models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Food::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Food model.
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
     * Creates a new Food model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Food();

        if ($model->load(Yii::$app->request->post())){


            if ( $model->save()) {
                $model->saveIngredients();
                return $this->redirect(['index']);
            }
        }

        $ingredients = Ingredient::find()->where(['status' => Ingredient::STATUS_ACTIVE])->all();
        $listIngredients   = ArrayHelper::map( $ingredients,'id','name');

        $paramIngredients = [];

        return $this->render('create', [
            'model' => $model,
            'listIngredients' => $listIngredients,
            'paramIngredients' => $paramIngredients,
        ]);
    }

    /**
     * Updates an existing Food model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = Food::find()->where(['id' => $id])->with(['ingredients'])->one();


        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $model->saveIngredients();
                return $this->redirect(['index']);
            }
        }

        $ingredients = Ingredient::find()->where(['status' => Ingredient::STATUS_ACTIVE])->all();
        $listIngredients   = ArrayHelper::map( $ingredients,'id','name');

        $paramIngredients = [];

        if (!empty($model->ingredients)) {
            foreach ($model->ingredients as $ingredient) {
                $paramIngredients[$ingredient['id']] = ['selected' => true];
            }
        }

        return $this->render('update', [
            'model' => $model,
            'listIngredients' => $listIngredients,
            'paramIngredients' => $paramIngredients,
        ]);
    }

    /**
     * Deletes an existing Food model.
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
     * Finds the Food model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Food the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Food::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionList()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = \Yii::$app->request->post();

        if (!empty($data['ingredients'])) {
            $result = Food::getFoodsByIngredients($data['ingredients']);

            if ($result) {
                return $result;
            } else {
                \Yii::$app->response->statusCode = 404;
                return ['error' => 'Could not find elements'];
            }

        } else {
            \Yii::$app->response->statusCode = 404;
            return ['error' => 'Could not find elements'];
        }
    }
}
