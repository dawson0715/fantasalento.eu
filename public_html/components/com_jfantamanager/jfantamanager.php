<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Get an instance of the controller prefixed by jFantaManager
$controller = JControllerLegacy::getInstance('jFantaManager');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();