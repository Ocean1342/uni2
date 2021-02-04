<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Call */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="call-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'call_id')->textInput() ?>
    <?= $form->field($model, 'account_id')->textInput() ?>
    <?= $form->field($model, 'mentor_id')->textInput() ?>
    <?= $form->field($model, 'sip_id')->textInput() ?>
    <?= $form->field($model, 'created_at')->textInput()?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
