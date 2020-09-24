<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Request;

/**
 * RequestSearch represents the model behind the search form of `app\models\Request`.
 */
class RequestSearch extends Request
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'carry', 'topup_acc_type', 'amount', 'charge_amount', 'min_card_value', 'cach_nap', 'dau_gia', 'type', 'thoi_gian_cho', 'status', 'chuyen_mang_giu_su', 'user_id'], 'integer'],
            [['account', 'note', 'callback_url', 'tran_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Request::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'carry' => $this->carry,
            'topup_acc_type' => $this->topup_acc_type,
            'amount' => $this->amount,
            'charge_amount' => $this->charge_amount,
            'min_card_value' => $this->min_card_value,
            'cach_nap' => $this->cach_nap,
            'dau_gia' => $this->dau_gia,
            'type' => $this->type,
            'thoi_gian_cho' => $this->thoi_gian_cho,
            'status' => $this->status,
            'chuyen_mang_giu_su' => $this->chuyen_mang_giu_su,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'callback_url', $this->callback_url])
            ->andFilterWhere(['like', 'tran_id', $this->tran_id]);

        return $dataProvider;
    }
}
