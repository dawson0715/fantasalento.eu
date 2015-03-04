<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.model');

/**
 * HelloWorld Model
 */
class jFantaManagerModelRose extends JModel
{
        
        function getSquadre()
        {
            $db =& JFactory::getDBO();
            $lega=JRequest::getVar('lega', '');
            if($lega==0)
                $lega=1;
            
            $query ="SELECT id,nome,bilancio FROM `#__fanta_squadra` 
                    WHERE `lega` = $lega";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        
        function getGiocatori($id)
        {
            $data = date('Y-m-d');    
            $db =& JFactory::getDBO();
            
            $query ="SELECT pos,nome,valore_acq,squadra
                    FROM `#__fanta_possiede` 
                    LEFT JOIN #__fanta_giocatore
                        ON(#__fanta_possiede.giocatore_id = #__fanta_giocatore.id)
                    WHERE #__fanta_possiede.squadra_id = $id
                        AND data_ces <= $data
                    ORDER BY pos DESC,nome";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
}