<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the jFantaManager Component
 */
class jFantaManagerViewFreeGiocatori extends JViewLegacy
{
	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
                $this->portieri         = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('P');
                $this->difensori        = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('C');
                $this->centrocampisti   = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('D');
                $this->attaccanti       = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('A');
                $this->options          = $this->get('Options');
                //$lista = $this->get("Giocatoris");
                 
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                
                //$this->lista      = $lista;//$squadra;
                
                $this->root=JURI::root();
                $document = &JFactory::getDocument();
                $document->addStyleSheet('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'freegiocatori.css');
                $document->addScript('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'freegiocatori.js');
		// Display the view
		parent::display($tpl);
	}
}
