<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ChatworkAuth */

$this->title = Yii::t('app', 'create_new_push');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'chatwork_auth_index_title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="chatwork-auth-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
