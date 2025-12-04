<?php

use app\models\Course;
use app\models\PayType;
use app\models\Status;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdminSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="application-search ">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="d-flex justify-content-between align-items-end gap-3 flex-wrap">

        <?php echo $form->field($model, 'pay_type_id')->dropDownList(PayType::getPayTypes(), ['prompt' => 'Вид оплаты']) ?>
        <?php echo $form->field($model, 'course_id')->dropDownList(Course::getCourses() + [100 => "Другой вариант"], ['prompt' => 'Вид курса']) ?>



        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Сброс', 'index', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>