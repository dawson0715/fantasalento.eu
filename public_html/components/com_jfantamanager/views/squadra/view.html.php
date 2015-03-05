<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the jFantaManager Component
 */
class jFantaManagerViewSquadra extends JViewLegacy
{
	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
		// Assign data to the view
                $this->items = $this->get('Items');
                $this->squadra=strtolower($_GET['squadra']);
                
                $grab1 = file("http://www.gazzetta.it/Calcio/Squadre/".ucfirst(strtolower($this->squadra))."/");

                if (strlen(strip_tags($grab1[1533])) > 50) {$gn = strip_tags($grab1[1533]);$tit = strip_tags($grab1[1532]);}
                elseif (strlen(strip_tags($grab1[1532])) > 50) {$gn = strip_tags($grab1[1532]);$tit = strip_tags($grab1[1531]);}
                
//                $this->grub="http://www.gazzetta.it/Calcio/Squadre/".ucfirst(strtolower($this->squadra));
                
                unset($grab1);

                $this->news = "<b><u>Ultime notizie Gazzetta:</u></b>
                    <h1>".$tit."</h1><br />".$gn;

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}
