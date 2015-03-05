<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the jFantaManager Component
 */
class jFantaManagerViewRose extends JViewLegacy
{
	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
		// Assign data to the view
		$squadre=$this->get('Squadre');
		$lista = "";
		
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


		$document = &JFactory::getDocument();
		$document->addStyleSheet('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'visualizza.css');
		// Display the view
		parent::display($tpl);
	}
}
