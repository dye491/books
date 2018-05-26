<?php

namespace app\models;

use Yii;

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
            [['point_id'], 'exist', 'skipOnError' => true, 'targetClass' => Point::className(), 'targetAttribute' => ['point_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
}
