<?php

namespace backend;

//use common\activeRecords\Admin;
use common\models\User;
use yii\web\IdentityInterface;

/**
 * 实现user组件
 * Class Authentication
 * @package adminApi\modules\v1
 */
class Authentication extends User implements IdentityInterface
{

    /**
     * @param int|string $id
     *
     * @return Authentication|IdentityInterface|null
     */
    public static function findIdentity( $id )
    {
        return static::findOne( [ 'id' => $id ] );
    }

    /**
     * @param mixed $token
     * @param null  $type
     *
     * @return void|IdentityInterface
     */
    public static function findIdentityByAccessToken( $token , $type = null )
    {
        return self::findOne( [ 'auth_key' => $token ] );
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     *
     * @return bool
     */
    public function validateAuthKey( $authKey )
    {
        return $this->getAuthKey() === $authKey;
    }
}