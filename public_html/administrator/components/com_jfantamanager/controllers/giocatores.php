<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class jFantaManagerControllerGiocatores extends JControllerForm
{
 
    public function getModel($name = 'Giocatore', $prefix = 'jFantaManagerModel')
    {
            $model = parent::getModel($name, $prefix, array('ignore_request' => true));
            return $model;
    }
    /*
     * NUOVO (Inserisci una nuova)
     * 
     * MODIFICA (Inserisci piu seleziona uno da cambiare e cambia le date)
     * 
     * ELIMINA (Elimina la riga)
     * 
     */
    public function cancel()
    {
        $msg = JText::_( "Errore nell'aggiornamento della lista voti" );
        $this->setRedirect( 'index.php?option=com_jfantamanager', $msg );
    }

    
}
