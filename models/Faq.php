<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $categoryId
 * @property string $question
 * @property string $answer
 * @property string $created_at
 *
 * @property User $user
 */
class Faq extends \yii\db\ActiveRecord {

    public static $CategoryStr = [
        '1' => 'Financial',
        '2' => 'Technique',
        '3' => 'Adding Posts',
        '20' => 'Other',
    ];
    
    public $email;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['userId', 'categoryId','published'], 'integer'],
            [['question', 'answer'], 'required'],
            [['created_at','email','lang'], 'safe'],
            [['question','lang'], 'string', 'max' => 500],
            [['answer'], 'string', 'max' => 3000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'userId' => 'User',
            'categoryId' => 'Type',
            'question' => 'Question',
            'answer' => 'Answer',
            'created_at' => 'Added on',
            'email'=>'Send Email to user'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

}
