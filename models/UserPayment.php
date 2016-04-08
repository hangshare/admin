<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_payment".
 *
 * @property integer $id
 * @property integer $userId
 * @property double $price
 * @property string $payer_email
 * @property integer $start_date
 * @property integer $end_date
 * @property string $planId
 * @property string $transactionId
 */
class UserPayment extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['userId', 'price', 'payer_email', 'start_date', 'end_date', 'planId', 'transactionId'], 'required'],
            [['userId', 'start_date', 'end_date'], 'integer'],
            [['price'], 'number'],
            [['payer_email'], 'string', 'max' => 200],
            [['planId'], 'string', 'max' => 50],
            [['transactionId'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'price' => 'Price',
            'payer_email' => 'Payer Email',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'planId' => 'Plan ID',
            'transactionId' => 'Transaction ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

}
