<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mesa;

/**
 * MesaSearch represents the model behind the search form about `app\models\Mesa`.
 */
class MesaSearch extends Mesa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idMesa',  'alerta', 'cont'], 'integer'],
            [['numeroDaMesa', 'qrcode', 'chave'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Mesa::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'=> ['defaultOrder' => ['idMesa'=>SORT_DESC]],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idMesa' => $this->idMesa,

            'alerta' => $this->alerta,
            'cont' => $this->cont,
        ]);

        $query->andFilterWhere(['like', 'numeroDaMesa', $this->numeroDaMesa])
            ->andFilterWhere(['like', 'qrcode', $this->qrcode])
            ->andFilterWhere(['like', 'chave', $this->chave]);

        return $dataProvider;
    }
}
