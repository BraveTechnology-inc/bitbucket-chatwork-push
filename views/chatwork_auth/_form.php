<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChatworkAuth */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">

    $(function() {
        $("#chatworkauth-bitbucket_url").focusout(function(){
            var val = $("#chatworkauth-bitbucket_url").val()
            var val2 = $("#chatworkauth-repo_name").val();
            if (0 < val.length) {
                var arr = val.split('/');
                if (0 < arr.length && val2.length == 0) {
                    $("#chatworkauth-repo_name").val(arr[arr.length - 1]);
                }
            }
        })
    });
</script>

<div class="chatwork-auth-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bitbucket_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repo_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'register') : Yii::t('app', 'edit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
