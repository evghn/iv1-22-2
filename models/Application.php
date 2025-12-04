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

    const SCENARIO_COURSE_LIST = 'list';
    const SCENARIO_COURSE_TEXT = 'text';
    const SCENARIO_MASTER = 'master';


    public $check;

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
            [['date_start', 'user_id', 'pay_type_id', 'status_id', 'time_order'], 'required'],
            [['course_id'], 'required', 'on' => [self::SCENARIO_COURSE_LIST, self::SCENARIO_MASTER]],
            [['master_id'], 'required', 'on' => [self::SCENARIO_MASTER]],

            [['course_user'], 'required', 'on' => self::SCENARIO_COURSE_TEXT],

            [['date_start', 'created_at'], 'safe'],
            [['course_user'], 'string', 'max' => 255],
            [['user_id', 'course_id', 'pay_type_id', 'status_id', 'master_id'], 'integer'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            // [['date_start'], 'date', 'min' => date('d.m.Y'), 'format' => 'dd.MM.yyyy'],
            ['time_order', 'time', 'format' => 'php:H:i', 'min' => "09:00", "message" => "Время должно быть с часовым интервалом"],
            [['check'], 'boolean'],
            [['date_start'], 'validateMaster', 'on' => [self::SCENARIO_MASTER]],

            // 9 - 18
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
            'course_user' => 'Свой курс',
        ];
    }


    public function validateMaster($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $result = static::find()
                ->where(
                    'master_id = ' . $this->master_id
                        . " and status_id <> " . Status::getStausId('final')
                        . " and date_start = '{$this->date_start}'"
                        . " and time_order = '{$this->time_order}:00'"
                )
                // ->count()
                ->createCommand()
                ->rawSql;
            var_dump($result);
            die;
            if ($result) {
                $this->addError('time_order', 'Мастер на эту дата-время занят!');
            }
        }
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

    public function getMaster()
    {
        return $this->hasOne(Master::class, ['id' => 'master_id']);
    }
}
