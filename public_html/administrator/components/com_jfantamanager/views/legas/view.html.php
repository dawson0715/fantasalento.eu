<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class jFantaManagerViewLegas extends JView
{
	protected $page;
        /**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null)
	{

		
                $items = $this->get('Items');
		$pagination = $this->get('Pagination');
                $giornata = $this->get('Giorno');//38;//jFantaManagerHelper::getGiornata();
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                
                for($i=1;$i<=$giornata;$i++)
                    $options[] = JHtml::_('select.option', $i, $i);
                
                $this->giorno = $giornata;
                $this->options=$options;
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

                // Set the toolbar
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}

        protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_SHOPPING_MANAGER_LEGAS'));
                $bar = & JToolBar::getInstance('toolbar');
                // Add an upload button
                JToolBarHelper::custom ('legas.aggiorna_giocatori','aggiorna.png','aggiorna.png','Aggiorna Lista',false,false);
                $bar->appendButton( 'Popup', 'Voti giornata', 'Voti giornata', "index.php?option=com_jfantamanager&view=voto&tmpl=component", 800, 400 );
                JToolBarHelper::divider();
                JToolBarHelper::custom ('legas.calcola','calcola.png','calcola.png','Calcola',false,false);
                JToolBarHelper::custom ('legas.recupera','calcola.png','calcola.png','Recupera',false,false);
                JToolBarHelper::custom('legas.carica_voti','carica.png','carica.png','Carica Voti',false,false);
                $bar->appendButton( 'Popup', 'upload', 'Carica file (DA FARE)', "components/com_jfantamanager/views/upload/index.php?gid=$this->giorno", 800, 400 );
                JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'legas.delete');
                JToolBarHelper::editList('lega.edit','Modifica Campionato');
		JToolBarHelper::addNew('lega.add');
                

	}
}