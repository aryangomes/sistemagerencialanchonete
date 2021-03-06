<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Loja;

/**
 * LojaSearch represents the model behind the search form about `app\models\Loja`.
 */
class LojaSearch extends Loja
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['nome', 'endereco'], 'safe'],
        [['user_id'], 'integer'],
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
        $query = Loja::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => Yii::$app->user->getId(),
            ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
        ->andFilterWhere(['like', 'endereco', $this->endereco]);

        return $dataProvider;
    }
}
