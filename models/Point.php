<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "point".
 *
 * @property int $id
 * @property string $title
 * @property string $address
 * @property string $desc
 *
 * @property Book[] $books
 */
class Point extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'point';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'address'], 'required'],
            [['title', 'address', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'title'   => 'Наименование',
            'address' => 'Адрес',
            'desc'    => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['point_id' => 'id']);
    }
}
