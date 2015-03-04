<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class jFantaManagerViewGiocatore extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	public function display($tpl = null)
	{
                $squadra_id = JRequest::getVar('squadra_id','');
		// Get data from the model
                $form = $this->get('Form');
		$item = $this->get('Item');
		$pagination = $this->get('Pagination');
                
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                
		// Assign data to the view
                $this->form = $form;
		$this->item = $item;
                $this->table= jFantaManagerModelGiocatore::getGiocatori($item->pos);
		$this->pagination = $pagination;
                $this->squadra_id = $squadra_id;

		// Display the template
		parent::display($tpl);
	}
}