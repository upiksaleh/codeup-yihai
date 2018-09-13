<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\theming;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Button::widget([
 *     'label' => 'Action',
 *     'options' => ['class' => 'btn-lg'],
 * ]);
 * ```
 * @see http://getbootstrap.com/javascript/#buttons
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since 2.0
 */
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

class Button extends Widget
{
    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'button';
    /**
     * @var string the button label
     */
    public $label = 'Button';
    /**
     * @var bool whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;

    /**
     * @var string type button [default|primary|success|info|danger|warning|etc]
     */
    public $type = '';

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        Theme::initWidget('button', $this);
        $this->clientOptions = false;
        if($this->type)
            Html::addCssClass($this->options, ['widget_type' => Theme::btnType($this->type)]);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('button');
        return Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
    }
    public static function primary($label, $config = []){
        $config['label'] = $label;
        $config['type'] = 'primary';
        return self::widget($config);
    }
}
