<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;


class Theme extends \yii\base\Theme
{
    public $basePath = '@app/views';
    /**
     * mengganti attribut pada saat merender attribut tag html
     * contoh mengganti uk-button ke btn
     * ```php
     * [
     *      'uk-button' => 'btn'
     * ]
     * ```
     * @var array list attribut
     */
    public $attributes_replace = [
        '{ctheme}container-fluid'    => 'container-fluid',
        '{ctheme}row'    => 'row',
        '{ctheme}col-'   => 'col-',
        '{ctheme}table'  => 'table',
        // BUTTONS
        '{ctheme}btn'    => 'btn',

        '{ctheme}text-' => 'text-',
        '{ctheme}alert-' => 'alert-',
        '{ctheme}list-' => 'list-',

    ];
    public function init()
    {
        parent::init();
    }

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
    }
}