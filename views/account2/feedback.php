<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = "Заявка: №" . $model->application->id . " от " . Yii::$app->formatter->asDatetime($model->application->created_at, 'php:d.m.Y H:i:s');
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Заявка №" . $model->application->id, 'url' => ['view', 'id' => $model->application->id]];
$this->params['breadcrumbs'][] = 'Отзыв';
?>
<div class="application-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_feedback', [
        'model' => $model,
    ]) ?>

</div>