<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\theming;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class BoxCard
 * Widget boxcard
 * @package codeup\theming
 */
class BoxCard extends Widget
{
    /**
     * @var string type atau style box. ex: primary|success|danger ....etc
     */
    public $type = 'default';

    public $title;

    public $header = true;
    public $headerOptions;

    public $headerTools = [];
    public $headerBorder = true;
    public $headerToolsOptions;

    public $bodyOptions;

    public $footer = false;
    public $footerContent;
    public $footerOptions;
    public $tools_order = ['badge', 'collapse', 'remove'];

    public $loading = false;
    public $isCollapsed = false;
    /** @var string konten setelah body */
    public $afterBody;

    // --------------------------------------------------------------------
    /**
     * Initializes the widget.
     */
    public function init()
    {
        Html::addCssClass($this->options, ['box', 'box-'.$this->type, ($this->isCollapsed ? 'collapsed-box':'')]);
        echo Html::beginTag('div', $this->options);
        if($this->header) {
            Html::addCssClass($this->headerOptions, 'box-header' . ($this->headerBorder ? ' with-border' : ''));
            echo Html::beginTag('div', $this->headerOptions);
            echo Html::tag('h3', $this->title, ['class' => 'box-title']);
            $this->_initHeaderTools();
            echo Html::endTag('div');
        }
        Html::addCssClass($this->bodyOptions, "box-body");
        echo Html::beginTag('div', $this->bodyOptions);
    }

    // --------------------------------------------------------------------
    public function run()
    {
        echo Html::endTag('div');   //body
        if($this->afterBody)
            echo $this->afterBody;
        if($this->loading){
            echo Html::tag('div', Html::faicon(['refresh','spin']), ['class'=>'overlay']);
        }
        $this->_initFooter();
        echo Html::endTag('div');   // box
    }

    private function _initHeaderTools(){
        Html::addCssClass($this->headerToolsOptions, ['box-tools pull-right']);
        echo Html::beginTag('div', $this->headerToolsOptions);
        if(in_array('collapse',$this->tools_order)){
            $this->headerTools['collapse'] = Html::button(
                Html::faicon(($this->isCollapsed?'plus':'minus')),
                [
                    'class'=>'btn btn-box-tool',
                    'data-widget'=>'collapse'
                ]
            );
        }
        if(in_array('remove',$this->tools_order)){
            $this->headerTools['remove'] = Html::button(
                Html::faicon('times'),
                [
                    'class'=>'btn btn-box-tool',
                    'data-widget'=>'remove'
                ]
            );
        }
        foreach($this->tools_order as $name){
            if(isset($this->headerTools[$name]))
                echo $this->headerTools[$name];
        }
        echo Html::endTag('div');
    }

    private function _initFooter(){
        if($this->footer){
            echo Html::beginTag('div',['class'=>'box-footer']);
            echo $this->footerContent;
            echo Html::endTag('div');
        }
    }

}