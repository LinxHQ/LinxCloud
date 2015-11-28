<?php
/**
 * TbDatePicker widget class
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiBooster bootstrap.widgets
 *
* Example :
 *	$this->widget('ext.rezvan.RDatePicker',array(
 *		'name'=>'Tasks[taskDate]',
 *		'options' => array(
 *			'format' => 'yyyy/mm/dd',
 *			'viewformat' => 'yyyy/mm/dd',
 *			'placement' => 'right',
 *		)
 *	));	 
 */
class RDatePicker extends CInputWidget
{
	/**
	 * @var TbActiveForm when created via TbActiveForm, this attribute is set to the form that renders the widget
	 * @see TbActionForm->inputRow
	 */
	public $form;
	/**
	 * @var array the options for the Bootstrap JavaScript plugin.
	 */
	public $options = array();
	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->htmlOptions['type'] = 'text';
		$this->htmlOptions['autocomplete'] = 'off';

		if (!isset($this->options['language']))
			$this->options['language'] = Yii::app()->language;

		if (!isset($this->options['format']))
			$this->options['format'] = 'yyyy/mm/dd';

		if (!isset($this->options['weekStart']))
			$this->options['weekStart'] = 0; // Sunday
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		if ($this->hasModel())
		{
			if($this->form)
				echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
			else
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);

		} else
			echo CHtml::textField($name, $this->value, $this->htmlOptions);

		$this->registerClientScript($id);
	}

	/**
	 * Registers required client script for bootstrap datepicker. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript($id)
	{
		$baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.rezvan').'/assets');

		$cs=Yii::app()->getClientScript();
		$cs->registerCssFile($baseScriptUrl.'/css/bootstrap-datepicker.css');
		$cs->registerScriptFile($baseScriptUrl.'/js/jalali.js', CClientScript::POS_END);
		$cs->registerScriptFile($baseScriptUrl.'/js/calendar.js', CClientScript::POS_END);
		$cs->registerScriptFile($baseScriptUrl.'/js/bootstrap-datepicker.js', CClientScript::POS_END);
		/* $cs->registerScriptFile($baseScriptUrl.'/js/bootstrap-datepicker.'.$this->options['language'].'.js', CClientScript::POS_END);
		
		Yii::app()->bootstrap->registerAssetCss('bootstrap-datepicker.css');
		Yii::app()->bootstrap->registerAssetJs('bootstrap.datepicker.js');
		if(isset($this->options['language']))
		{
			Yii::app()->bootstrap->registerAssetJs('locales/bootstrap-datepicker.'.$this->options['language'].'.js', CClientScript::POS_END);
		} */
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		ob_start();
		echo "jQuery('#{$id}').datepicker({$options})";
		foreach ($this->events as $event => $handler)
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');

	}
}