<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

use yii\base\InvalidConfigException;

/**
 * Class Cii
 * @author Upik Saleh <upxsal@gmail.com>
 */
class Cii extends \yii\BaseYii
{

    /**
     * @return null|\codeup\Models\UserIdent
     */
    public static function getUserIdentity(){
        if(static::$app->user->identity instanceof \codeup\Models\UserIdent){
            return static::$app->user->identity;
        }
        throw new InvalidConfigException(static::t('codeup','class user identity harus instance {class}',['class'=>'\codeup\Models\UserIdent']));

    }

    /**
     * @param string $key
     * @param null|string|array $default    default value jika tidak ditemukan key pada params
     * @return array|null|mixed
     */
    public static function getParams($key = '', $default = null)
    {
        if(empty($key)){
            return static::$app->params;
        }

        if(isset(static::$app->params[$key])){
            return static::$app->params[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed $val
     */
    public static function setParams($key, $val){
        static::$app->params[$key] = $val;
    }
}