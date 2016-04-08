<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_stats".
 *
 * @property integer $userId
 * @property integer $post_views
 * @property integer $post_total_views
 * @property integer $post_count
 * @property integer $profile_views
 * @property double $total_amount
 * @property double $available_amount
 * @property double $cantake_amount
 *
 * @property User $user
 */
class UserStats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_stats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'post_views', 'post_total_views', 'post_count', 'profile_views', 'total_amount', 'available_amount', 'cantake_amount'], 'required'],
            [['userId', 'post_views', 'post_total_views', 'post_count', 'profile_views'], 'integer'],
            [['total_amount', 'available_amount', 'cantake_amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'post_views' => 'Post Views',
            'post_total_views' => 'Post Total Views',
            'post_count' => 'Post Count',
            'profile_views' => 'Profile Views',
            'total_amount' => 'Total Amount',
            'available_amount' => 'Available Amount',
            'cantake_amount' => 'Cantake Amount',
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
