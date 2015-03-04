<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * HelloWorlds Controller
 */
class jFantaManagerControllerSquadras extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Squadra', $prefix = 'jFantaManagerModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
        
        function Permetti()
	{
		$model = $this->getModel();
		if($model->Permesso(1))
                    $msg = JText::_( 'L\'utente selezionata ha accesso al fantacalcio' );
                else
                    $msg = JText::_( 'Errore: Non è possibile permettere a quest\'utente di partecipare' );

		// Check th->Permesso();
		$this->setRedirect( 'index.php?option=com_jfantamanager&view=squadras', $msg );
	}
        
        function Blocca()
	{
		$model = $this->getModel();
		if($model->Permesso(2))
                    $msg = JText::_( 'L\'utente selezionata ha accesso al fantacalcio' );
                else
                    $msg = JText::_( 'Errore: Non è possibile bloccare quest\'utente' );

		$this->setRedirect( 'index.php?option=com_jfantamanager&view=squadras', $msg );
	}
        
        function Reset()
	{
		$model = $this->getModel();
		if($model->Permesso(0))
                    $msg = JText::_( 'Reset dei permessi effettuato con successo' );
                else
                    $msg = JText::_( 'Errore: Non è possibile resettare i permessi di quest\'utente' );

		$this->setRedirect( 'index.php?option=com_jfantamanager&view=squadras', $msg );
	}
        
        public function delete()
        {
            // Initialise variables.
            $db     = JFactory::getDBO();
            $ids    = JRequest::getVar('cid', array(), '', 'array');
            
            // Check if I am a Super Admin
//            $iAmSuperAdmin = $user->authorise('core.admin');

            // Iterate the items to delete each one.
            foreach ($ids as $i => $id)
            {
                $db->setQuery("DELETE FROM #__fanta_possiede
                                WHERE squadra_id = $id");
                if (!$db->query()) {
                        $this->setError($db->getErrorMsg());
                        $squadra .= "-- Errore alla squadra $id -- <br>";
                }
                $squadra .= "Squadra $id eliminata con i suoi giocatori<br>";
            }

            $msg = JText::_( 'Squadra: '.$squadra.'<br>');
            $this->setRedirect( 'index.php?option=com_jfantamanager&view=squadras', $msg );
//            return;
            return parent::delete();
        }
}
