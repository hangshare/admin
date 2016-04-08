<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_transactions".
 *
 * @property integer $id
 * @property integer $userId
 * @property double $amount
 * @property integer $status
 * @property string $created_at
 *
 * @property User $user
 */
class UserTransactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'amount', 'status'], 'required'],
            [['userId', 'status'], 'integer'],
            [['amount'], 'number'],
            [['created_at','image'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'amount' => 'Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
