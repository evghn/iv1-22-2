<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master".
 *
 * @property int $id
 * @property string $name
 *
 * @property Application[] $applications
 */
class Master extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['master_id' => 'id']);
    }

    public static function getMsaters(): array
    {
        return static::find()
            ->select('name')
            ->indexBy('id')
            ->column()
        ;
    }
}
