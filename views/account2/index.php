<?php

use app\models\Application;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-outline-success']) ?>
        <?= Html::a('Создать заявку 2025', ['create2025'], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Создать заявку 2026 - master', ['create-master'], ['class' => 'btn btn-outline-primary']) ?>
    </p>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
    ]) ?>


</div>