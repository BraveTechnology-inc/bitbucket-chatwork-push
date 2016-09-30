<?php

use app\models\ChatworkAuth;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ChatworkAuth */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'chatwork_auth_index_title'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chatwork-auth-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'bitbucket_url:url',
            'repo_name',
            [
                'label' => Yii::t('app', 'api_key'),
                'value' => $model->getChatworkApiKey()
            ],
            'room_id',
            'created',
            'updated',
        ],
    ]) ?>

    <div class="">
        <h3 class="page-header"><?=Yii::t('app', 'push_guide_header')?></h3>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_url_header')?></h4></div>
            <div class="panel-body">
                <?='http://'.$_SERVER['HTTP_HOST'].'/chatwork_push_api/push?push_id='.$model->id?>
            </div>
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_image_header')?></h4></div>
            <div class="panel-body">
                <img src="/images/setting/setting_image01.png" width="400px"/>
            </div>
        </div>
    </div>

    <div class="">
        <h3 class="page-header"><?=Yii::t('app', 'issue_add_guide_header')?></h3>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_url_header')?></h4></div>
            <div class="panel-body">
                <?='http://'.$_SERVER['HTTP_HOST'].'/chatwork_push_api/issue_add?push_id='.$model->id?>
            </div>
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_image_header')?></h4></div>
            <div class="panel-body">
                <img src="/images/setting/setting_image02.png" width="400px"/>
            </div>
        </div>
    </div>

    <div class="">
        <h3 class="page-header"><?=Yii::t('app', 'issue_edit_guide_header')?></h3>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_url_header')?></h4></div>
            <div class="panel-body">
                <?='http://'.$_SERVER['HTTP_HOST'].'/chatwork_push_api/issue_edit?push_id='.$model->id?>
            </div>
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_image_header')?></h4></div>
            <div class="panel-body">
                <img src="/images/setting/setting_image03.png" width="400px"/>
            </div>
        </div>
    </div>

    <div class="">
        <h3 class="page-header"><?=Yii::t('app', 'issue_comment_guide_header')?></h3>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_url_header')?></h4></div>
            <div class="panel-body">
                <?='http://'.$_SERVER['HTTP_HOST'].'/chatwork_push_api/issue_comment?push_id='.$model->id?>
            </div>
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_image_header')?></h4></div>
            <div class="panel-body">
                <img src="/images/setting/setting_image04.png" width="400px"/>
            </div>
        </div>
    </div>

    <div class="">
        <h3 class="page-header"><?=Yii::t('app', 'issue_pull_request_add_guide_header')?></h3>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_url_header')?></h4></div>
            <div class="panel-body">
                <?='http://'.$_SERVER['HTTP_HOST'].'/chatwork_push_api/pull_request_add?push_id='.$model->id?>
            </div>
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_image_header')?></h4></div>
            <div class="panel-body">
                <img src="/images/setting/setting_image05.png" width="400px"/>
            </div>
        </div>
    </div>

    <div class="">
        <h3 class="page-header"><?=Yii::t('app', 'issue_pull_request_declined_guide_header')?></h3>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_url_header')?></h4></div>
            <div class="panel-body">
                <?='http://'.$_SERVER['HTTP_HOST'].'/chatwork_push_api/pull_request_declined?push_id='.$model->id?>
            </div>
            <div class="panel-heading"><h4><?=Yii::t('app', 'setting_image_header')?></h4></div>
            <div class="panel-body">
                <img src="/images/setting/setting_image06.png" width="400px"/>
            </div>
        </div>
    </div>
</div>
