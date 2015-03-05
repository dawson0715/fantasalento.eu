<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the jFantaManager Component
 */
class jFantaManagerViewClassifica extends JViewLegacy
{
	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
		// Assign data to the view
		$this->items = $this->get('Items');

                $chart	= $this->get('Gocatori');
                $this->chart   =  $chart;
                
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                
                $this->chart_punti = $this->get('GraficoPartecipa');
                $this->root=JURI::root();
                //include css file
                $document = &JFactory::getDocument();
                $document->addStyleSheet('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'visualizza.css');
                $document->addScriptDeclaration('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'jquery-1.4.2.min.js');
		// Display the view
		parent::display($tpl);
	}
}
