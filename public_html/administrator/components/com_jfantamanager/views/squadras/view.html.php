<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class jFantaManagerViewSquadras extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$items      = $this->get('Items');
		$pagination = $this->get('Pagination');
                
                $this->state    = $this->get('State');
                $options	= $this->get('Options');
		$this->options  =$options;
                
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JFANTAMANAGER_MANAGER_SQUADRAS'));
                JToolBarHelper::custom ('legas.calcola','calcola.png','calcola.png','Calcola',false,false);
                JToolBarHelper::custom ('legas.recupera','calcola.png','calcola.png','Recupera',false,false);
                JToolBarHelper::divider();
                JToolBarHelper::custom ('squadras.permetti','','','Permetti',true,false);
                JToolBarHelper::custom ('squadras.blocca','','','Bloca',true,false);
                JToolBarHelper::custom ('squadras.reset','','','Reset',true,false);
                JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'squadras.delete');
		JToolBarHelper::editList('squadra.edit');
		JToolBarHelper::addNew('squadra.add');
	}
}
