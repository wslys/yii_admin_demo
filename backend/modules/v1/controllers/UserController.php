<?php

namespace backend\modules\v1\controllers;

use backend\base\controllers\ApiController;

/**
 * 用户控制器
 * Class UserController
 * @package api\modules\v1\controllers
 */
class UserController extends ApiController
{

    /**
     * 指定ORM模型
     * @var string
     */
    public $modelClass = 'common\models\User';

    /**
     * 登录
     * @return array
     */
    public function actionTtst()
    {
        echo 'ddsds';
    }
}