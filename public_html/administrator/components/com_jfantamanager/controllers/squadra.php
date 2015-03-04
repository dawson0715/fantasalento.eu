<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * HelloWorld Controller
 */
class jFantaManagerControllerSquadra extends JControllerForm
{
        
//public function save($key = null, $urlVar = null)
//    {
//            $db = JFactory::getDBO();
//            $rosa = JRequest::getVar('valore', array(), 'post', 'array');
//            $scelto = JRequest::getVar('scelto', array(), 'post', 'array');
//            $squadra = JRequest::getVar('id','');
//            $isnew = JRequest::getVar('news','');
//            
//            if($isnew)
//                foreach ($rosa as $id => $valore)
//                {
//                    $giocatore  =   new stdClass();
//                    $giocatore->giocatore_id  = $scelto[$i];
//                    $giocatore->squadra_id = $squadra_id;
//                    $giocatore->valore_acq = $valore[$i];
//                    $giocatore->data_acq = date('Y-m-d');
//                    $db->insertObject('#__fanta_possiede', $giocatore);
//                }
//            else
//            foreach ($rosa as $id => $valore)
//            {
//                $db->setQuery(" UPDATE `#__fanta_possiede` 
//                                    SET `valore_acq` = $valore,
//                                        `giocatore_id` = $scelto[$id]
//                                WHERE `squadra_id` = $squadra 
//                                AND `giocatore_id` = $id");
//                $db->query();
////                $valente="UPDATE `#__fanta_possiede` 
////                                    SET `valore_acq` = $valore,
////                                     `giocatore_id` = $scelto[$id]
////                                WHERE `squadra_id` = $squadra 
////                                AND `giocatore_id` = $id";
//            }
//
//          
//            return parent::save();
//            $msg = JText::_( "La squadra $rosa[0] <br> " );
//            $this->setRedirect( 'index.php?option=com_jfantamanager&view=squadra&layout=edit', $msg );
//    }
}
