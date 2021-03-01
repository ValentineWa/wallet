<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Wallet;
use frontend\models\Country;




/* @var $this yii\web\View */
/* @var $model frontend\models\Deposit */
/* @var $form ActiveForm */
?>
<div class="deposit">

    <?php $form = ActiveForm::begin(); ?>

       
       
        <?= $form->field($model, 'walletId')->dropDownList(ArrayHelper::map(Wallet::find()->where(['userId'=>yii::$app->user->id])->asArray()->all(), 'walletId', 'walletName')) ?> <?= $form->field($model, 'createdBy')->hiddenInput(['value'=>yii::$app->user->id])->label(false) ?>
        <?= $form->field($model, 'transAmount') ?>
        <?= $form->field($model, 'phoneCode')->dropDownList(ArrayHelper::map(Country::find()->all(), 'couPhoneCode', 'countryName'))?>
        <?= $form->field($model, 'mpesaNumber')->textInput() ?>
        <?= $form->field($model, 'details')->textInput() ?>
        <?= $form->field($model, 'createdBy')->hiddenInput(['value'=>yii::$app->user->id])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- deposit -->

