<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property string $date_start
 * @property int $user_id
 * @property int $course_id
 * @property int $pay_type_id
 * @property int $status_id
 * @property string $created_at
 *
 * @property Course $course
 * @property Feedback $feedback
 * @property PayType $payType
 * @property Status $status
 * @property User $user
 */
class Application extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'user_id', 'course_id', 'pay_type_id', 'status_id'], 'required'],
            [['date_start', 'created_at'], 'safe'],
            [['user_id', 'course_id', 'pay_type_id', 'status_id'], 'integer'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'date_start' => 'Дата начала обучения',
            'user_id' => 'Клиент',
            'course_id' => 'Наименование курса',
            'pay_type_id' => 'Способ оплаты',
            'status_id' => 'Статус заявки',
            'created_at' => 'Дата создания заявки',
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    /**
     * Gets query for [[Feedback]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedback()
    {
        return $this->hasOne(Feedback::class, ['application_id' => 'id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
