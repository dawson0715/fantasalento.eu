<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class FantacalcioViewUpload extends JView
{
	protected $page;
        /**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null)
	{

            
//                $items = $this->get('Items');
//		$pagination = $this->get('Pagination');
//                
//                $this->state    = $this->get('State');
//                
//		// Check for errors.
//		if (count($errors = $this->get('Errors')))
//		{
//			JError::raiseError(500, implode('<br />', $errors));
//			return false;
//		}
//                $options[] = JHtml::_('select.option', "", "Posizione");
//                $options[] = JHtml::_('select.option', "P", "Portieri");
//                $options[] = JHtml::_('select.option', "D", "Difensori");
//                $options[] = JHtml::_('select.option', "C", "Centrocampisti");
//                $options[] = JHtml::_('select.option', "A", "Attaccanti");
//                $this->options=$options;
//		// Assign data to the view	
//		$this->pagination = $pagination;

                // Set the toolbar
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}

        protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_SHOPPING_MANAGER_LEGAS'));
                JToolBarHelper::custom ('legas.calcola','','','Calcola',false,false);
                JToolBarHelper::divider();
                JToolBarHelper::custom ('legas.aggiorna_giocatori','','','Aggiorna Lista',false,false);
                JToolBarHelper::custom('legas.aggiorna_voti','','','Aggiorna Voti',false,false);
                JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'legas.delete');
                JToolBarHelper::editList('lega.edit','Modifica Campionato');
		JToolBarHelper::addNew('lega.add');
	}
}