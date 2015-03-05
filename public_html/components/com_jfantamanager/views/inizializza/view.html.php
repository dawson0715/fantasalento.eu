<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the jFantaManager Component
 */
class jFantaManagerViewInizializza extends JViewLegacy
{

        protected $_item;
//        data;
//	protected $form;

	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
                $this->permessi = jFantaManagerHelper::getPermessi();
                $user   = &JFactory::getUser();
                
                /*
                if ($user->partecipa!='1')
                     $this->msg="COM_JFANTAMANAGER_PARTECIPA";
                
                    $campionati=explode(';', $user->partecipa);
                if(in_array(0, $campionati))
                    $this->msg="COM_JFANTAMANAGER_NON_PARTECIPA";
                else if (count($campionati)>1)
                {
                    $lega=JRequest::getVar('lega', '' , 'post');
                    if ($lega=='' || $lega==0)
                    {    
                        $this->legas=$this->get('Legas');
                        $this->msg="COM_JFANTAMANAGER_PARTECIPA";
                    }
                    elseif(in_array($lega, $campionati))
                    {
                        $this->parametri = jFantaManagerHelper::getParameters($lega);
                    }
                    else
                        $this->msg="COM_JFANTAMANAGER_PARTECIPA";
                }
                else//Partecipa solo ad un campionato quindi i parametri sono quelli giusti 
                    $this->parametri = jFantaManagerHelper::getParameters($campionati[0]);
                */
                
                if($user->id<=0)
                     $this->msg="COM_JFANTAMANAGER_PERMESSI_USER";
                else if($this->get('Creata')>0)
                    $this->msg="COM_JFANTAMANAGER_PERMESSI_EXIST";

                if ($this->msg != '')
                {
                    parent::display($tpl);
                    return;
                }
                if(JRequest::getVar('rosa', '' , 'post')!='')
                {   
                    $this->salvato = jFantaManagerModelInizializza::Salva($this->parametri,$this->permessi);
                    // Display the view
                    parent::display($tpl);
                    return;
                }
//                $form = $this->get('Form');
		$itemsP = $this->get('ListaP');
                $itemsD = $this->get('ListaD');
                $itemsC = $this->get('ListaC');
                $itemsA = $this->get('ListaA');
                $options = $this->get('Options');
                
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                $this->lega=$lega;
                $this->options=$options;
                $this->portieri=$itemsP;
                $this->difensori=$itemsD;
                $this->centrocampisti=$itemsC;
                $this->attaccanti=$itemsA;
                
		$this->root=JURI::root();
		// Display the view
                
                $document = &JFactory::getDocument();
                $document->addStyleSheet('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'inizializza.css');
                $document->addScript('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'inizializza.js');
		parent::display($tpl);
	}
}
?>