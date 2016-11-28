<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_queue".
 *
 * @property integer $id
 * @property integer $emailId
 * @property integer $type
 * @property integer $opened_num
 * @property integer $start_at
 * @property integer $end_at
 * @property integer $status
 */
class EmailQueue extends \yii\db\ActiveRecord
{

    public $toIdStr = [
        '1' => 'HangShare Users',
        '2' => 'Email List',
        '10' => 'Both'
    ];
    public $typeStr = [
        '1' => 'Newsletter',
        '2' => 'Custom Email'
    ];
    public $postTypeStr = [
        '1' => 'Newest Most Viewed',
        '2' => 'Newest Featured',
        '3' => 'Newest Posts',
        '4' => 'Selected Posts'
    ];
    public $subject, $body, $postNum, $postType, $SelectedPosts, $end_at, $toId;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emailId', 'type', 'opened_num', 'start_at', 'end_at', 'status'], 'required'],
            [['emailId', 'type', 'opened_num', 'start_at', 'end_at, toId', 'status'], 'integer'],
            [['subject', 'body', 'SelectedPosts', 'postType', 'postNum', 'toId', 'end_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emailId' => 'Email ID',
            'type' => 'Type',
            'opened_num' => 'Opened Num',
            'start_at' => 'Start At',
            'end_at' => 'End At',
            'status' => 'Status',
            'postNum' => 'Number of Articles to Send',
            'postType' => 'Selected Articles',
        ];
    }

}
