<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property string $desc
 * @property int $issueYear
 * @property int $point_id
 * @property int $user_id
 * @property int $status
 * @property int $rating
 * @property string $imagePath
 *
 * @property Point $point
 * @property User $user
 */
class Book extends \yii\db\ActiveRecord
{
    const STATUS_FREE = 0,
        STATUS_BUSY = 1;

    /**
     * @var UploadedFile $imageFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'point_id'], 'required'],
            [['issueYear', 'point_id', 'user_id', 'status', 'rating'], 'integer'],
            [['title', 'author', 'desc', 'imagePath'], 'string', 'max' => 255],
            [['point_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Point::className(), 'targetAttribute' => ['point_id' => 'id']],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['imageFile', 'image',
                'skipOnEmpty' => true,
                'maxSize'     => 2000000,
                'extensions'  => 'gif jpg png',
//                'mimeTypes'   => 'image/gif image/jpg image/png',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'title'     => 'Название',
            'author'    => 'Автор',
            'desc'      => 'Описание',
            'issueYear' => 'Год издания',
            'point_id'  => 'Point ID',
            'user_id'   => 'User ID',
            'status'    => 'Статус',
            'rating'    => 'Рейтинг',
            'imagePath' => 'Иконка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoint()
    {
        return $this->hasOne(Point::className(), ['id' => 'point_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function take($user_id)
    {
        if ($this->status === self::STATUS_FREE /*&& !$this->user_id*/) {
            $this->status = self::STATUS_BUSY;
            $this->user_id = $user_id;
            $this->rating += 1;
            return $this->save();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function free()
    {
        if (/*$this->status === self::STATUS_FREE*/
            0 || !$this->user_id)
            return false;

        $this->status = self::STATUS_FREE;
        $this->user_id = null;

        return $this->save();
    }

    public function upload()
    {
        if ($this->validate()) {
            $uploadPath = Yii::getAlias('@app/upload/');
            $path = Yii::$app->user->id . '/' . (new \DateTime())->format('Y-m-d');
            if (!file_exists($path)) mkdir($path, 0775, true);
            $filePath = $path . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($uploadPath . $filePath);
            return $filePath;
        } else {
            return false;
        }
    }
}
