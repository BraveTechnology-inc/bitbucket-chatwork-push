<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChatworkAuth */

$this->title = $model->repo_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'chatwork_auth_index_title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->repo_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'update_push');
?>
<div class="chatwork-auth-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
