<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = 'Создание заявки';
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'courses' => $courses,
        'payTypes' => $payTypes,
    ]) ?>

</div>