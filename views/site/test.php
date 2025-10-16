<?php

use yii\bootstrap5\Html;
use yii\web\JqueryAsset;

?>
<div id="calc" class="d-flex gap-3 mt-5 align-items-center">
    <div><?= Html::a('➖', ['site/test', 'action' => 'minus'], ['class' => 'btn btn-minus']) ?></div>
    <div class="value">0</div>
    <div><?= Html::a('➕', ['site/test', 'action' => 'plus'], ['class' => 'btn btn-plus']) ?></div>
</div>
<?php
$this->registerJsFile('/js/calc.js', ['depends' => JqueryAsset::class]);
