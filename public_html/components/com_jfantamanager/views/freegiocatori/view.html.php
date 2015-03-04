<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class jFantaManagerViewFreeGiocatori extends JView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
                $this->portieri = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('P');
                $this->difensori = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('C');
                $this->centrocampisti = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('D');
                $this->attaccanti = jFantaManagerModelFreegiocatori::FreeGiocatoriByPos('A');
                $this->options = $this->get('Options');
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
                $document->addStyleSheet('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'profile.css');
                $document->addScriptDeclaration('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'freegiocatori.js');
		// Display the view
		parent::display($tpl);
	}
}
