<?php

namespace app\controllers;

use Yii;
use app\models\Pagamento;
use app\models\PagamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PagamentoController implements the CRUD actions for Pagamento model.
 */
class PagamentoController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Pagamento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagamentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pagamento model.
     * @param integer $idConta
     * @param integer $idPedido
     * @return mixed
     */
    public function actionView($idConta, $idPedido)
    {
        return $this->render('view', [
            'model' => $this->findModel($idConta, $idPedido),
        ]);
    }

    /**
     * Creates a new Pagamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pagamento();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idConta' => $model->idConta, 'idPedido' => $model->idPedido]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Pagamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idConta
     * @param integer $idPedido
     * @return mixed
     */
    public function actionUpdate($idConta, $idPedido)
    {
        $model = $this->findModel($idConta, $idPedido);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idConta' => $model->idConta, 'idPedido' => $model->idPedido]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pagamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idConta
     * @param integer $idPedido
     * @return mixed
     */
    public function actionDelete($idConta, $idPedido)
    {
        $this->findModel($idConta, $idPedido)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pagamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idConta
     * @param integer $idPedido
     * @return Pagamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idConta, $idPedido)
    {
        if (($model = Pagamento::findOne(['idConta' => $idConta, 'idPedido' => $idPedido])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
