<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChatworkApiKey */
/* @var $message string */

$this->title = Yii::t('app', 'title_update_chatwork_api_key');
$this->params['breadcrumbs'][] = Yii::t('app', 'title_update_chatwork_api_key');
?>
<div class="chatwork-api-key-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (isset($message)) {?>
        <div class="alert alert-success"><?=$message?></div>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
