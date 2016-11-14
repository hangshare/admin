<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $postId
 * @property string $comment
 * @property string $created_at
 * @property integer $parentId
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'postId', 'comment'], 'required'],
            [['userId', 'postId', 'parentId'], 'integer'],
            [['created_at'], 'safe'],
            [['comment'], 'string', 'max' => 2000]
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
            'postId' => 'Post ID',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'parentId' => 'Parent ID',
        ];
    }
}
