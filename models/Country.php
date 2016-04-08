<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_ar
 * @property string $code
 * @property double $price
 * @property integer $regionId
 * @property integer $published
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'name_ar', 'code', 'price', 'regionId'], 'required'],
            [['price'], 'number'],
            [['regionId', 'published'], 'integer'],
            [['name', 'name_ar'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 3]
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
            'name_ar' => 'Name Ar',
            'code' => 'Code',
            'price' => 'Price',
            'regionId' => 'Region ID',
            'published' => 'Published',
        ];
    }
    
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion() {
        return $this->hasOne(Region::className(), ['id' => 'regionId']);
    }
}
