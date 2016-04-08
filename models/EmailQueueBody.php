<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_queue_body".
 *
 * @property integer $id
 * @property string $body
 */
class EmailQueueBody extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_queue_body';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['body','subject'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'body' => 'Body',
        ];
    }
}
