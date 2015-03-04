<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class jFantaManagerViewSquadra extends JView
{
	protected $lista;

        /**
	 * HelloWorlds view display method
	 * @return void
	 */
	public function display($tpl = null)
	{
                $squadra_id = JRequest::getVar('id','');
		// Get data from the model
                $form       = $this->get('Form');
		$item       = $this->get('Item');
                $lista      = $this->get('Lista');
                if (count($lista)==0)
                {
                    $this->isnew=true;
                    $this->posizione['P']  = jFantaManagerModelSquadra::getGiocatori('P');
                    $this->posizione['D']  = jFantaManagerModelSquadra::getGiocatori('D');
                    $this->posizione['C']  = jFantaManagerModelSquadra::getGiocatori('C');
                    $this->posizione['A']  = jFantaManagerModelSquadra::getGiocatori('A');
                }
//                else{
//                    $this->posizione['P']  = jFantaManagerModelSquadra::getPosizioni('P');
//                    $this->posizione['D']  = jFantaManagerModelSquadra::getPosizioni('D');
//                    $this->posizione['C']  = jFantaManagerModelSquadra::getPosizioni('C');
//                    $this->posizione['A']  = jFantaManagerModelSquadra::getPosizioni('A');
//                }
                $options = $this->get('Options');
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Assign data to the view$this->portieri=$itemsP;
		$this->options=$options;
		$this->form = $form;
		$this->squadra_id = $squadra_id;
		$this->item = $item;
		$this->lista=$lista;
		
		// Set the toolbar
		$this->addToolBar();
		
		$document = &JFactory::getDocument();
		$document->addStyleSheet('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'inizializza.css');
		//$document->addScriptDeclaration('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'inizializza.js');
		// Display the template
		parent::display($tpl);
	}

        protected function addToolBar()
	{
                JRequest::setVar('hidemainmenu', true);
                $isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_JFANTAMANAGER_MANAGER_SQUADRA_NEW') : JText::_('COM_JFANTAMANAGER_MANAGER_SQUADRA_EDIT'));
                JToolBarHelper::save('squadra.save');
                JToolBarHelper::cancel('squadra.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}