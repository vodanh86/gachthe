<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string|null $account
 * @property int|null $carry
 * @property int|null $topup_acc_type
 * @property int|null $amount
 * @property int|null $charge_amount
 * @property int|null $min_card_value
 * @property int|null $cach_nap
 * @property int|null $dau_gia
 * @property int|null $type
 * @property int|null $thoi_gian_cho
 * @property int|null $status
 * @property string|null $note
 * @property int|null $chuyen_mang_giu_su
 * @property string|null $callback_url
 * @property string|null $tran_id
 * @property string|null $response
 * @property int|null $user_id
 * @property int $created_time
 * @property int $updated_time
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'charge_amount', 'min_card_value', 'cach_nap', 'dau_gia', 'type', 'thoi_gian_cho', 'status', 'chuyen_mang_giu_su', 'user_id', 'created_time'], 'integer'],
            [['carry',  'account', 'topup_acc_type', 'tran_id'], 'string', 'max' => 45],
            [['note'], 'string', 'max' => 245],
            [['callback_url'], 'string', 'max' => 545],
            [['response'], 'string', 'max' => 2545],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => 'Account',
            'carry' => 'Carry',
            'topup_acc_type' => 'Topup Acc Type',
            'amount' => 'Amount',
            'charge_amount' => 'Charge Amount',
            'min_card_value' => 'Min Card Value',
            'cach_nap' => 'Cach Nap',
            'dau_gia' => 'Dau Gia',
            'type' => 'Type',
            'thoi_gian_cho' => 'Thoi Gian Cho',
            'status' => 'Status',
            'note' => 'Note',
            'chuyen_mang_giu_su' => 'Chuyen Mang Giu Su',
            'callback_url' => 'Callback Url',
            'tran_id' => 'Tran ID',
            'user_id' => 'User ID',
            'response' => 'Response',
        ];
    }
}
