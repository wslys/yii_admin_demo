<?php

namespace backend\base\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use Yii;

/**
 * restful api 底层控制器
 * Class ApiController
 * @package api\base\controllers
 */
class ApiController extends ActiveController
{

    /**
     * 操作成功标示码
     */
    const ACTION_SUCCESS_CODE = 1;

    /**
     * 操作失败标示码
     */
    const ACTION_FAIL_CODE = 0;

    /**
     * 开发的权限
     * @var array
     */
    private $allowedApis = [
        'user/login' ,
    ];

    /**
     * 关闭csrf验证
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 验证授权
     *
     * @param array $optional
     *
     * @return array
     */
    public function behaviors( $optional = [] )
    {
        $behaviors = parent::behaviors();
        $behaviors[ 'authenticator' ] = [
            'class' => HttpBasicAuth::className() ,
        ];
        return $behaviors;
    }

    /**
     * 重写
     *
     * @param $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction( $action )
    {
        if ( $this->isAllowedApi() ) {
            return true;
        }
        parent::beforeAction( $action );
        return true;
    }

    /**
     * 注销自带的 rest
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset(
            $actions[ 'index' ] ,
            $actions[ 'update' ] ,
            $actions[ 'create' ] ,
            $actions[ 'delete' ]
        );
        return $actions;
    }

    /**
     * 验证是否是开发的接口请求
     * @return bool
     */
    private function isAllowedApi()
    {
        $controllerId = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $requestApi = $controllerId . '/' . $action;
        return in_array( $requestApi , $this->allowedApis );
    }

    /**
     * 操作成功
     *
     * @param array  $data
     * @param int    $count
     * @param string $msg
     *
     * @return array
     */
    public function success( $data = [] , $count = 0 , $msg = '操作成功' )
    {
        return [
            'code' => self::ACTION_SUCCESS_CODE ,
            'message' => $msg ,
            'count' => $count ,
            'data' => $data ,
        ];
    }

    /**
     * 操作失败
     *
     * @param string $msg
     * @param array  $data
     * @param int    $count
     *
     * @return array
     */
    public function fail( $msg = '操作失败' , $data = [] , $count = 0 )
    {
        return [
            'code' => self::ACTION_FAIL_CODE ,
            'message' => $msg ,
            'count' => $count ,
            'data' => $data ,
        ];
    }
}