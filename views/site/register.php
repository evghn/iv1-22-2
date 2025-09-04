<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\helpers\VarDumper;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

// VarDumper::dump($model2, 10, true);
// die;

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>


            <?= $form->field($model, 'full_name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'phone') ?>

            <?= $form->field($model, 'login') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <div class="d-flex justify-content-between align-items-baseline">
                    <?= Html::a('Авторизация', 'login', ['class' => 'd-flex align-self-baseline']) ?>
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


</div>