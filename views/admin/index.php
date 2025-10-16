<?php

use app\models\Application;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\AdminSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <h3 class="my-3"><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin(); ?>
    <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap">
        <div class="mb-3 d-flex justify-content-between align-items-end flex-wrap gap-2">
            Сортировка:
            <?= $dataProvider->sort->link('id')
                . ' | '
                . $dataProvider->sort->link('created_at')
                . ' | '
                . $dataProvider->sort->link('date_start')
            ?>
        </div>
        <?= $this->render('_search', ['model' => $searchModel]);
        ?>
    </div>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
    ]) ?>
    <?php Pjax::end() ?>


</div>