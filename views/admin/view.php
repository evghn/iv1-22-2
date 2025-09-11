<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = "Заявка: №" . $model->id . " от " . Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p class="d-flex gap-3 my-3">
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s'),
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->user->full_name,
            ],
            [
                'attribute' => 'date_start',
                'value' => Yii::$app->formatter->asDate($model->date_start, 'php:d.m.Y'),
            ],
            [
                'attribute' => 'course_id',
                'value' => $model->course->title,
            ],
            [
                'attribute' => 'pay_type_id',
                'value' => $model->payType->title,
            ],
            [
                'attribute' => 'status_id',
                'value' => $model->status->title,
            ],
            [
                'label' => 'Отзыв',
                'visible' => (bool)$model?->feedback,
                'format' => 'html',
                'value' => $model?->feedback ? nl2br($model->feedback->comment) : '',

            ]

        ],
    ]) ?>

</div>