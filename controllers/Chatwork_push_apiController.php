<?php

namespace app\controllers;

use app\models\ChatworkAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class Chatwork_push_apiController extends ActiveController
{
    public $modelClass = 'ChatworkAuth';

    public function behaviors()
    {
        // レスポンスをjsonに固定
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }

    /**
     * 共通リクエストパラメータをチェックする
     * @param $push_id
     * @return ChatworkAuth
     * @throws BadRequestHttpException
     */
    private function validateCommon($push_id)
    {
        if (!isset($push_id) || strlen($push_id) == 0) {
            throw new BadRequestHttpException(\Yii::t('app/error', 'id_not_found'));
        }

        $model = ChatworkAuth::findById($push_id);
        if (!isset($model)) {
            throw new BadRequestHttpException(\Yii::t('app/error', 'id_not_found'));
        }

        return $model;
    }

    /**
     * bitbucketのIDが正しいか判定する
     * @throws BadRequestHttpException
     */
    private function validateIP()
    {
        if (YII_ENV_DEV) {
            return true;
        }

        $ip     = $_SERVER["REMOTE_ADDR"];
        $ipLast = explode($ip, '.');

        if (strpos($ip, '131.103.20') !== false) {
            // file_put_contents('./sample.txt', $_POST);
        } else if (strpos($ip, '165.254.145') !== false) {
            // file_put_contents('./sample.txt', $_POST);
        } else if (strpos($ip, '104.192.143') !== false) {
            // file_put_contents('./sample.txt', $_POST);
        } else {
            throw new BadRequestHttpException(\Yii::t('app/error', 'ip_wrong'));
        }

        return true;
    }

    /**
     * チャットワークへメッセージを送信する
     * @param $message
     * @param ChatworkAuth $model
     */
    private function sendPush($message, ChatworkAuth $model)
    {
        $data    = array(
            "body" => $message
        );
        $data    = http_build_query($data, "", "&");
        $header  = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: " . strlen($data),
            "X-ChatWorkToken: " . $model->getChatworkApiKey()
        );
        $context = array(
            "http" => array(
                "method" => "POST",
                "header" => implode("\r\n", $header),
                "content" => $data
            )
        );
        $url     = "https://api.chatwork.com/v1/rooms/" . $model->room_id . '/messages';
        file_get_contents($url, false, stream_context_create($context));
    }

    /**
     * PUSHの場合
     * @param null $push_id
     * @return array
     */
    public function actionPush($push_id = null) {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);
            $name = (string)$json['push']['changes'][0]['new']['name'];
            $hash = (string)$json['push']['changes'][0]['new']['target']['hash'];
            $hashLink = (string)$json['push']['changes'][0]['new']['target']['links']['html']['href'];
            $commitComment = (string)$json['push']['changes'][0]['new']['target']['message'];
            $actorName = (string)$json['actor']['display_name'];

            $message = $name."にpushされました。\r\n【ハッシュ】\r\n".$hash."\r\n".$hashLink."\r\n【ユーザー】\r\n".$actorName."\r\n【コメント】\r\n".$commitComment;
        }

        $this->sendPush($message, $model);
    }

    public function actionIssue_comment($push_id = null)
    {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);

            $type = (string)$json['issue']['kind'];
            $title = (string)$json['issue']['title'];
            $actorName = (string)$json['issue']['reporter']['display_name'];
            $detail = (string)$json['comment']['content']['raw'];
            $link = (string)$json['issue']['links']['html']['href'];

            $message = $actorName."によってコメントが追加されました。\r\n【issueタイトル】\r\n".$title."\r\n【コメント】\r\n".$detail."\r\n"."【リンク】\r\n".$link;
        }

        $this->sendPush($message, $model);
    }

    public function actionIssue_edit($push_id = null)
    {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);

            $changeType = $json['changes']['status']['new'];
            if ($changeType === 'resolved') {
                // 解決
                $type      = (string) $json['issue']['kind'];
                $title     = (string) $json['issue']['title'];
                $actorName = (string) $json['actor']['display_name'];
                $detail    = (string) $json['comment']['content']['raw'];
                $link      = (string) $json['issue']['links']['html']['href'];

                $message = $actorName . "によってissueが解決されました。【種別】\r\n" . $type . "\r\n【タイトル】\r\n" . $title . "\r\n【詳細】\r\n" . $detail . "\r\n" . "【リンク】\r\n" . $link;
            } else if ($changeType === 'new') {
                // 編集
                $type      = (string) $json['issue']['kind'];
                $title     = (string) $json['issue']['title'];
                $actorName = (string) $json['issue']['reporter']['display_name'];
                $detail    = (string) $json['issue']['content']['raw'];
                $link      = (string) $json['issue']['links']['html']['href'];

                $message = $actorName . "によってissueが変更されました。\r\n【種別】\r\n" . $type . "\r\n【タイトル】\r\n" . $title . "\r\n【詳細】\r\n" . $detail . "\r\n" . "【リンク】\r\n" . $link;
            }else{
                // 解決
                $type      = (string) $json['issue']['kind'];
                $title     = (string) $json['issue']['title'];
                $actorName = (string) $json['actor']['display_name'];
                $detail    = (string) $json['comment']['content']['raw'];
                $link      = (string) $json['issue']['links']['html']['href'];

                $message = $actorName . "によってissueが変更されました。【種別】\r\n" . $type . "\r\n【タイトル】\r\n" . $title . "\r\n【詳細】\r\n" . $detail . "\r\n" . "【リンク】\r\n" . $link;
            }
        }

        $this->sendPush($message, $model);
    }

    public function actionIssue_update($push_id = null)
    {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);

            $title = (string)$json['issue']['assignee']['title'];
            $actorName = (string)$json['issue']['reporter']['display_name'];
            $comment = (string)$json['comment']['content']['raw'];
            $link = (string)$json['comment']['links']['html']['href'];

            $message = $actorName."によってコメントが追加されました。\r\nタイトル:".$title."\r\nコメント:"."\r\n"."リンク:".$link;
        }

        $this->sendPush($message, $model);
    }

    public function actionIssue_add($push_id = null)
    {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);

            $type = (string)$json['issue']['kind'];
            $title = (string)$json['issue']['title'];
            $actorName = (string)$json['issue']['reporter']['display_name'];
            $detail = isset($json['comment']) ? (string)$json['comment']['content']['raw'] : '';
            $link = (string)$json['issue']['links']['html']['href'];

            $message = $actorName."によってissueが追加されました。\r\n【種別】\r\n".$type."\r\n【タイトル】\r\n".$title."\r\n"."【リンク】\r\n".$link;
        }

        $this->sendPush($message, $model);
    }

    public function actionPull_request_declined($push_id = null)
    {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);

            $actorName = (string)$json['actor']['display_name'];
            $detail = (string)$json['pullrequest']['reason'];
            $link = (string)$json['pullrequest']['links']['html']['href'];

            $message = $actorName."によってプルリクエストが却下されました。\r\n【却下理由】\r\n".$detail."\r\n".$link;
        }

        $this->sendPush($message, $model);
    }

    public function actionPull_request_add($push_id = null)
    {
        $this->validateIP();

        $model = $this->validateCommon($push_id);

        $message = file_get_contents('php://input');
        if(strlen($message) == 0){
            $message = 'no body';
        }else{
            $json = json_decode($message, true);

            $type = (string)$json['issue']['kind'];
            $title = (string)$json['pullrequest']['title'];
            $actorName = (string)$json['actor']['display_name'];
            $detail = (string)$json['pullrequest']['description'];
            $link = (string)$json['pullrequest']['links']['html']['href'];

            $message = $actorName."によってプルリクエストが追加されました。\r\n【タイトル】\r\n".$title."\r\n【詳細】\r\n".$detail."\r\n".$link;
        }

        $this->sendPush($message, $model);
    }
}
