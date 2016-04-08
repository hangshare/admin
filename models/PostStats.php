<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_stats".
 *
 * @property integer $postId
 * @property integer $views
 * @property integer $fb_share
 * @property integer $tw_share
 * @property integer $g_share
 * @property integer $comments
 */
class PostStats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_stats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postId', 'views', 'fb_share', 'tw_share', 'g_share', 'comments'], 'required'],
            [['postId', 'views', 'fb_share', 'tw_share', 'g_share', 'comments'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'postId' => 'Post ID',
            'views' => 'Views',
            'fb_share' => 'Fb Share',
            'tw_share' => 'Tw Share',
            'g_share' => 'G Share',
            'comments' => 'Comments',
        ];
    }
}
