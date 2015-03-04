<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**     #__fanta_possiede
 * squadra_id 	int(11) 	No 	0 		
 * giocatore_id 	int(11) 	No 	0 		
 * data_acq 	date 	No 	0000-00-00 		
 * data_ces 	date 	No 	0000-00-00 		
 * valore_acq 	int(11) 	No 	0 		
 * valore_ces 	int(11) 	No 	0
 */
class jFantaManagerControllerGiocatore extends JControllerForm
{
    public function save()
    {
        $db = JFactory::getDBO();
        
        $jform = JRequest::getVar('jform', array(), 'post', 'array');
        $squadra_id = JRequest::getVar('squadra_id','');
        //SE $jform['modifica']==true CAMBIO I VECCHI VALORI 
        if($jform['modifica'])
        {    $db->setQuery("UPDATE `#__fanta_possiede` 
                    SET data_acq = '".$jform['data_acq']."',
                        valore_acq = ".$jform['valore_acq']."
                    WHERE giocatore_id = ".$jform['giocatore_id']."
                        AND squadra_id = ".$jform['squadra_id']."");
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    $esito = $db->getErrorMsg();
            }
        }
        if($jform['conferma'])
        {//$jform['conferma'] INSERISCO UNA NUOVA RIGA DATA OGGI
            $data                 = new stdClass();
            $data->squadra_id     = $jform['squadra_id'];
            $data->giocatore_id   = $jform['new_giocatore_id'];
            $data->data_acq       = $jform['new_data_acq'];
            $data->valore_acq     = $jform['new_valore_acq'];
            $db->insertObject('#__fanta_possiede', $data);
            
            $data   = $jform['data_ces'];
            $valore = $jform['valore_ces'];
            //LA DATA CESSIONE E OGGI E IL VALORE = A QUELLO ACQUISTATO
            if($jform['data_ces']=='0000-00-00')
                $data   = date('Y-m-d');
            if($jform['valore_ces']=='0')
                $valore = $jform['valore_acq'];     

            $db->setQuery("UPDATE `#__fanta_possiede` 
                    SET data_ces = '$data',
                        valore_ces = $valore
                    WHERE giocatore_id = ".$jform['giocatore_id']."
                        AND squadra_id = ".$jform['squadra_id']."");
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    $esito = $db->getErrorMsg();
            }
        }
        
        
        $msg = JText::_( "La squadra $squadra_id <br> $esito" );
        $this->setRedirect( 'index.php?option=com_jfantamanager&view=giocatore', $msg );
    }
    
}
