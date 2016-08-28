<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $image
 * @property string $paypal_email
 * @property string $password_hash
 * @property string $bio
 * @property integer $gender
 * @property string $dob
 * @property integer $country
 * @property string $phone
 * @property string $password_reset_token
 * @property string $scId
 * @property integer $type
 * @property string $created_at
 *
 * @property UserSettings $userSettings
 * @property UserStats $userStats
 * @property UserTransactions[] $userTransactions
 */
class User extends \yii\db\ActiveRecord
{


    //public $transfer_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'image', 'paypal_email', 'password_hash', 'bio', 'gender', 'dob', 'country', 'phone', 'password_reset_token', 'scId', 'type'], 'required'],
            [['gender', 'country', 'type', 'plan', 'transfer_type', 'deleted'], 'integer'],
            [['dob', 'created_at', 'transfer_type'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
            [['image', 'paypal_email', 'password_hash'], 'string', 'max' => 250],
            [['bio'], 'string', 'max' => 600],
            [['phone'], 'string', 'max' => 25],
            [['password_reset_token'], 'string', 'max' => 200],
            [['scId'], 'string', 'max' => 500],
            [['email', 'paypal_email', 'password_hash'], 'unique', 'targetAttribute' => ['email', 'paypal_email', 'password_hash'], 'message' => 'The combination of Email, Paypal Email and Password Hash has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'image' => 'Image',
            'paypal_email' => 'Paypal Email',
            'password_hash' => 'Password Hash',
            'bio' => 'Bio',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'country' => 'Country',
            'phone' => 'Phone',
            'password_reset_token' => 'Password Reset Token',
            'scId' => 'Sc ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'deleted' => 'deleted',
            'total_amount'=>'Total',
            'available_amount'=>'Available',
            'cantake_amount'=>'Can Take',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasOne(UserSettings::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserStats()
    {
        return $this->hasOne(UserStats::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTransactions()
    {
        return $this->hasMany(UserTransactions::className(), ['userId' => 'id']);
    }

}
