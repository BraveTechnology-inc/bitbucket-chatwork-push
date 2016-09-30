<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ChatworkApiKey */

$this->title = Yii::t('app', 'Create Chatwork Api Key');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chatwork Api Keys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chatwork-api-key-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
