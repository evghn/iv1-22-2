<?php

use app\models\Application;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-outline-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            [
                'attribute' => 'created_at',
                'value' => fn($model) => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s'),
            ],
            [
                'attribute' => 'date_start',
                'value' => fn($model) => Yii::$app->formatter->asDate($model->date_start, 'php:d.m.Y'),
            ],
            [
                'attribute' => 'user_id',
                'value' => fn($model) => $model->user->full_name,
            ],
            [
                'attribute' => 'course_id',
                'value' => fn($model) => $model->course->title,
            ],
            [
                'attribute' => 'pay_type_id',
                'value' => fn($model) => $model->payType->title,
            ],
            [
                'attribute' => 'status_id',
                'value' => fn($model) => $model->status->title,
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


</div>