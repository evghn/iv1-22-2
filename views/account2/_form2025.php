<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Application $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="application-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-order'
        // 'enableClientValidation' => false
    ]); ?>

    <div class="w-25">
        <?= $form->field($model, 'date_start')->textInput(['type' => 'date'])
        ?>
        <?/* $form->field($model, 'date_start', ['enableAjaxValidation' => true])->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '99.99.9999',
        ]) */ ?>
        <?= $form->field($model, 'time_order')->textInput(['type' => 'time'/* , 'min' => '09:00', 'max' => '18:00' */]) ?>

    </div>

    <div class="w-50">
        <?= $form->field($model, 'course_id')->dropDownList($courses, ['prompt' => 'Выберете курс']) ?>
        <?= $form->field($model, 'check')->checkbox()->label('Другой курс') ?>

        <?= $form->field($model, 'course_user', ['options' => ['class' => 'd-none course_user']])->textInput()->label('Свой курс') ?>


    </div>


    <div class="w-50">
        <?= $form->field($model, 'pay_type_id')->dropDownList($payTypes, ['prompt' => 'Выберете способ оплаты']) ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-outline-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJsFile("/js/order2025.js", ['depends' => JqueryAsset::class]);
