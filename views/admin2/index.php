<?php

use app\models\Application;
use app\models\Course;
use app\models\PayType;
use app\models\Status;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="application-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php Pjax::begin() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
            ],

            [
                'attribute' => 'created_at',
                'value' => fn($model) => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s'),
                'filter' => false,
            ],
            [
                'attribute' => 'date_start',
                'value' => fn($model) => Yii::$app->formatter->asDate($model->date_start, 'php:d.m.Y'),
                'filter' => false,
            ],
            [
                'attribute' => 'user_id',
                'value' => fn($model) => $model->user->full_name,
                'filter' => false,
            ],
            [
                'attribute' => 'course_id',
                'value' => fn($model) => $model->course_id ? $model->course->title : $model->course_user,
                'filter' => Course::getCourses() + [100 => "Другой вариант"],
            ],
            [
                'attribute' => 'pay_type_id',
                'value' => fn($model) => $model->payType->title,
                'filter' => PayType::getPayTypes(),

            ],
            [
                'attribute' => 'status_id',
                'value' => fn($model) => $model->status->title,
                'filter' => Status::getStatuses(),
                // 'filter' => fn($model) => $model->status->title,
            ],
            [
                'label' => 'Действие',
                'format' => 'html',
                // https://iv1-22-2/account/view?id=1
                'value' => function ($model) {
                    $btn_view = Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']);
                    $btn_feedback = "";
                    if ($model->status->alias === 'finaly' && !$model?->feedback) {
                        $btn_feedback = Html::a('Отзыв', ['feedback', 'id' => $model->id], ['class' => 'btn btn-outline-warning']);
                    }

                    return "<div class='d-flex gap-3'>"
                        . $btn_view
                        . $btn_feedback
                        . "</div>";
                }
            ]

        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>