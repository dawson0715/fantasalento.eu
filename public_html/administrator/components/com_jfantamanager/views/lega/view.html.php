<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class jFantaManagerViewLega extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	public function display($tpl = null)
	{
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
		$this->pagination = $pagination;
                // Set the toolbar
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}

        protected function addToolBar()
	{
                JRequest::setVar('hidemainmenu', true);
                $isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_SHOPPING_MANAGER_LEGA_NEW') : JText::_('COM_SHOPPING_MANAGER_LEGA_EDIT'));
                JToolBarHelper::save('lega.save');
                JToolBarHelper::cancel('lega.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}