<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldPermessi extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Permessi';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
                $options[] = JHtml::_('select.option', "0", "Reset");
                $options[] = JHtml::_('select.option', "1", "Permesso");
                $options[] = JHtml::_('select.option', "2", "Bloccato");
		return $options;
	}
}
