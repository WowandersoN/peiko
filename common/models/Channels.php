<?php

namespace common\models;

use backend\components\Parser;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "channels".
 *
 * @property int $id
 * @property string $url
 * @property int $created_at
 */
class Channels extends ActiveRecord
{

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['created_at'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        /** @var Parser $parse **/
        $parser = Yii::$app->parser;
        $data = $parser->parse($this->url);
        foreach($data as $item){
            if(News::find()->where(['guid' => $item['guid']])->one()){
                continue;
            }
            $model = new News([
                'type' => 1,
                'guid' => $item['guid'],
                'short_text' => $item['title'],
                'img' => $item['image'],
                'small_img' => $item['image'],
                'long_text' => gettype($item['description']) == 'array' ? implode($item['description'], "<br>") : $item['description'] ,
                'created_at' => $item['publicationDate'],
            ]);
            if(!$model->save()){
                var_dump($model->errors);
                die();
            }
        }
    }
}
