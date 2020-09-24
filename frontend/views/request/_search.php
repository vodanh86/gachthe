<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'account') ?>

    <?= $form->field($model, 'carry') ?>

    <?= $form->field($model, 'topup_acc_type') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'charge_amount') ?>

    <?php // echo $form->field($model, 'min_card_value') ?>

    <?php // echo $form->field($model, 'cach_nap') ?>

    <?php // echo $form->field($model, 'dau_gia') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'thoi_gian_cho') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'chuyen_mang_giu_su') ?>

    <?php // echo $form->field($model, 'callback_url') ?>

    <?php // echo $form->field($model, 'tran_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'response_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
