<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\theming;


/**
 * Class RowCol
 * @package codeup\widgets\theming
 */
class RowCol extends Widget
{
    /**
     * @var string type untuk memulai row, default row
     */
    public $type = 'row';
    /**
     * @var array list class col
     */
    public $colClass = [];
    // --------------------------------------------------------------------
    public function init()
    {
        if($this->type === 'row') {
            Theme::initWidget('row', $this);
        }
        elseif($this->type === 'col') {
            Theme::initWidget('col', $this);
            if($this->colClass){
                Html::addCssClass($this->options, Theme::getClassCols($this->colClass));
            }
        }
        echo Html::beginTag('div',$this->options)."\n";
    }
    // --------------------------------------------------------------------
    public function run()
    {
        echo "\n" . Html::endTag('div');
    }
    // --------------------------------------------------------------------
    public static function row($config = []){
        self::begin($config);
    }
    // --------------------------------------------------------------------
    public static function col($colClass, $config = []){
        $config['type'] = 'col';
        $config['colClass'] = $colClass;
        self::begin($config);
    }
    // --------------------------------------------------------------------
    public static function endCol(){
        self::end();
    }
    // --------------------------------------------------------------------
    public static function endRow(){
        self::end();
    }
}