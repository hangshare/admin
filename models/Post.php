<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $cover
 * @property string $title
 * @property integer $type
 * @property integer $score
 * @property string $created_at
 */
class Post extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'cover', 'title', 'type'], 'required'],
            [['userId', 'type', 'deleted', 'published', 'score'], 'integer'],
            [['created_at, featured'], 'safe'],
            [['cover'], 'string', 'max' => 500],
            [['title'], 'string', 'max' => 250]
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStats()
    {
        return $this->hasOne(PostStats::className(), ['postId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'cover' => 'Cover',
            'title' => 'Title',
            'type' => 'Type',
            'score' => 'Score',
            'created_at' => 'Created At',
        ];
    }

}
