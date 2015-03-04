<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class jFantaManagerViewRose extends JView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// Assign data to the view
		$squadre=$this->get('Squadre');
                foreach ($squadre as $i => $squadra)
                    $lista[$squadra->id] = jFantaManagerModelRose::getGiocatori($squadra->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                $this->squadre  =$squadre;
                $this->giocatori=$lista;
		// Display the view
		parent::display($tpl);
	}
}
