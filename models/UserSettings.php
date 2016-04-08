<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_settings".
 *
 * @property integer $userId
 * @property integer $verified_email
 * @property integer $newsletter
 * @property string $key
 *
 * @property User $user
 */
class UserSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'verified_email', 'newsletter', 'key'], 'required'],
            [['userId', 'verified_email', 'newsletter'], 'integer'],
            [['key'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'verified_email' => 'Verified Email',
            'newsletter' => 'Newsletter',
            'key' => 'Key',
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
