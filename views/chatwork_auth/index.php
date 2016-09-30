<?php

use app\models\ChatworkAuth;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'chatwork_auth_index_title');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chatwork-auth-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'create_new_push'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bitbucket_url:url',
            'repo_name',
            'room_id',
            [
                'label' => Yii::t('app', 'api_key'),
                'value' => function(ChatworkAuth $model) {
                    return $model->getChatworkApiKey();
                }
            ],
            // 'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
