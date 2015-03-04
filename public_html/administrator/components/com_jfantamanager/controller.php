<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of HelloWorld component
 */
class jFantaManagerController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false)
	{
                require_once JPATH_COMPONENT.'/helpers/fantacalcios.php';
		// Load the submenu.
		jFantaManagersHelper::addSubmenu(JRequest::getCmd('view', 'legas'));

		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'Legas'));

		// call parent behavior
		parent::display($cachable);
	}
}