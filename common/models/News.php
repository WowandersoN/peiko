<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $short_text
 * @property string $long_text
 * @property string $small_img
 * @property string $img
 * @property int $type
 * @property int $created_at
 */
class News extends ActiveRecord
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
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'default', 'value' => 0],
            [['long_text'], 'string'],
            [['type', 'created_at'], 'integer'],
            [['short_text', 'small_img', 'img'], 'string', 'max' => 500],
            [['guid', 'link', 'short_text', 'long_text'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'short_text' => Yii::t('app', 'Short Text'),
            'long_text' => Yii::t('app', 'Long Text'),
            'small_img' => Yii::t('app', 'Small Img'),
            'img' => Yii::t('app', 'Img'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function upload(){

        if((false != ($small_img = UploadedFile::getInstance($this, 'small_img' )))){
            $small_filename = time() . $small_img->baseName . '.' . $small_img->extension;
            $small_path = Yii::getAlias('@frontend') . '/web/uploads/small_img';
            if($small_img->saveAs($small_path . DIRECTORY_SEPARATOR . $small_filename)){
                $this->small_img = $small_filename;
                $this->save();
            }
        }
        if(false != ($img = UploadedFile::getInstance($this, 'img' ))){
            $filename = time() . $img->baseName . '.' . $img->extension;
            $path = Yii::getAlias('@frontend') . '/web/uploads/img';
            if($img->saveAs($path . DIRECTORY_SEPARATOR . $filename)){
                $this->img = $filename;
                $this->save();
            }
        }
        return $this->save();
    }

}
