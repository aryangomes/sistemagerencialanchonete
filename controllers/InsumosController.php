<?php

namespace app\controllers;

use Yii;
use app\models\Insumos;
use app\models\InsumosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Produto;
use app\models\InputInsumos;
use yii\base\Model;
/**
 * InsumosController implements the CRUD actions for Insumos model.
 */
class InsumosController extends Controller
{
    public function behaviors()
    {
        return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        ];
    }

    /**
     * Lists all Insumos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InsumosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Insumos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($idprodutoVenda, $idprodutoInsumo) 
    { 
        return $this->render('view', [ 
            'model' => $this->findModel($idprodutoVenda, $idprodutoInsumo), 
            ]); 
    } 

    /**
     * Creates a new Insumos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Insumos();
        $produtosvenda = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>0])->all(), 
            'idProduto','nome');
        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>1])->all(), 
            'idProduto','nome');
        $model2 = new InputInsumos();
        $numeroinputs = 1;
        $settings = Insumos::find()->indexBy('idprodutoVenda')->all();

        if ((Yii::$app->request->post('numeroinputs')) ) {
          $numeroinputs = (Yii::$app->request->post()["numeroinputs"]);
          return $this->render('create', [
            'model' => $model,
            'insumos' => $insumos,
            'produtosvenda' => $produtosvenda,
            'model2'=>$model2,
            'numeroinputs'=>$numeroinputs,

            ]);
      }else{
        //if (Insumos::loadMultiple($settings, Yii::$app->request->post())){
        if ($model->load(Yii::$app->request->post()) ) {


          //  var_dump(Yii::$app->request->post('Insumos')['$i']['quantidade']);
        //  var_dump(Yii::$app->request->post('Insumos'));
            $aux = Yii::$app->request->post()['Insumos'];
            $n = count($aux['idprodutoInsumo']);
            echo $n;
            for ($i=0; $i < $n ; $i++) { 
             /*     echo "idprodutoVenda.:" . $aux['idprodutoVenda'];
                echo "</br>";
                echo "idprodutoInsumo.:" . $aux['idprodutoInsumo'][$i];
                echo "</br>";
                echo "quantidade.:" . $aux['quantidade'][$i];
                echo "</br>";
                echo "unidade.:" . $aux['unidade'][$i];
                echo "</br>";
                echo "</br>";*/
             //  var_dump($aux['quantidade'][$i]);
                Yii::$app->db->createCommand(
                    "INSERT INTO insumos
                    (idprodutoVenda, idprodutoInsumo,
                        quantidade,unidade ) 
                VALUES (:idprodutoVenda, :idprodutoInsumo,
                    :quantidade,:unidade)", [
                ':idprodutoVenda' => $aux['idprodutoVenda'],
                ':idprodutoInsumo'=> $aux['idprodutoInsumo'][$i],
                ':quantidade' => $aux['quantidade'][$i],
                ':unidade'=> $aux['unidade'][$i],
                ])->execute();
              /*  $model->idprodutoInsumo = $aux['idprodutoInsumo'][$i];
                $model->idprodutoVenda = $aux['idprodutoVenda'];
                $model->quantidade = $aux['quantidade'][$i];
                $model->unidade = $aux['unidade'][$i];
                $model->save(false);
             */

            } 


            return $this->redirect(['view', 'idprodutoVenda' => $model->idprodutoVenda, 'idprodutoInsumo' => $model->idprodutoInsumo]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'insumos' => $insumos,
                'produtosvenda' => $produtosvenda,
                'model2'=>$model2,
                'numeroinputs'=>$numeroinputs,
                ]);
        }
    }
}

    /**
     * Updates an existing Insumos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */



    public function actionUpdate($idprodutoVenda, $idprodutoInsumo) 
    { 
        $model = $this->findModel($idprodutoVenda, $idprodutoInsumo); 

        $produtosvenda = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>0])->all(), 
            'idProduto','nome');
        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>1])->all(), 
            'idProduto','nome');
        $model2 = new InputInsumos();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idprodutoVenda' => $model->idprodutoVenda, 'idprodutoInsumo' => $model->idprodutoInsumo]); 
        } else {
            return $this->render('update', [
                'model' => $model,
                'insumos' => $insumos,
                'produtosvenda' => $produtosvenda,
                'model2'=>$model2,
                ]);
        }
    }

    /**
     * Deletes an existing Insumos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($idprodutoVenda, $idprodutoInsumo) 
    { 
        $this->findModel($idprodutoVenda, $idprodutoInsumo)->delete(); 

        return $this->redirect(['index']); 
    } 
    /**
     * Finds the Insumos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Insumos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idprodutoVenda, $idprodutoInsumo) 
    { 
        if (($model = Insumos::findOne(['idprodutoVenda' => $idprodutoVenda, 'idprodutoInsumo' => $idprodutoInsumo])) !== null) {
            return $model; 
        } else { 
            throw new NotFoundHttpException('The requested page does not exist.'); 
        } 
    } 
}
