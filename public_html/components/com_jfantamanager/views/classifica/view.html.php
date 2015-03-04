<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class jFantaManagerViewClassifica extends JView
{
	// Overwriting JView display method
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
                $document->addStyleSheet('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'visualizza.css');
                $document->addScriptDeclaration('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'jquery-1.4.2.min.js');
		// Display the view
		parent::display($tpl);
	}
}
