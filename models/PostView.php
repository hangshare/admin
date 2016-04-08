<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_view".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $postId
 * @property string $ip
 * @property string $ip_info
 * @property string $hash
 * @property string $price
 * @property string $user_agent
 * @property string $created_at
 */
class PostView extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'post_view';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['userId', 'postId', 'ip', 'ip_info', 'hash', 'price', 'user_agent'], 'required'],
            [['userId', 'postId'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['ip'], 'string', 'max' => 20],
            [['ip_info'], 'string', 'max' => 1000],
            [['hash'], 'string', 'max' => 300],
            [['user_agent'], 'string', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'postId' => 'Post ID',
            'ip' => 'Ip',
            'ip_info' => 'Ip Info',
            'hash' => 'Hash',
            'price' => 'Price',
            'user_agent' => 'User Agent',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost() {
        return $this->hasOne(Post::className(), ['id' => 'postId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

}
