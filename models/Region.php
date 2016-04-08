<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property string $name
 * @property double $price
 */
class Region extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['price'], 'number'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
        ];
    }

    public static function get() {
        $regions = Yii::$app->cache->get('Region-list');
        if ($regions === false) {
            $region = Region::find()->all();
            $regions = Yii::$app->cache->set('Region-list', $region, 100);
        }
        return $regions;
    }

}
