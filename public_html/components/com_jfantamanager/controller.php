<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Hello World Component Controller
 */
class jFantaManagerController extends JController
{
    function display($cachable = false)
	{
                require_once JPATH_COMPONENT.'/helpers/fantacalcio.php';
		
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'all'));


		// call parent behavior
		parent::display($cachable);
	}
}