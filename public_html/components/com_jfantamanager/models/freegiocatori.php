<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * HelloWorld Model
 */
class jFantaManagerModelFreegiocatori extends JModelList
{
        function FreeGiocatoriByPos($pos)
        {
            $user = &JFactory::getUser();
            $db =& JFactory::getDBO();
            //$data = date('Y-m-d');

            $query ="SELECT FG.id, FG.nome, FG.pos, FG.squadra, COUNT( * ) AS P, SUM( voto ) AS V, SUM( totale ) AS T, SUM( ammonizione ) AS A, SUM( espulsione ) AS E, SUM( assist ) AS Ass, SUM( goal ) + SUM( rigore_segnato ) AS G, SUM( goal_subito ) AS Gs, SUM( rigore_parato ) AS Rp, SUM( rigore_sbagliato ) AS Rs
                        FROM jos_fanta_giocatore AS FG
                        LEFT JOIN jos_fanta_possiede AS FP ON ( FP.giocatore_id = FG.id ) 
                        LEFT JOIN jos_fanta_voti AS FV ON ( FG.id = FV.giocatore_id ) 
                        WHERE FP.giocatore_id IS NULL 
                        AND pos =  '$pos'
                        GROUP BY FG.id
                        ORDER BY nome ASC ";
            
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        
        function getOptions()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT DISTINCT squadra as text FROM #__fanta_giocatore ORDER BY text";
            $db->setQuery( $query );
            $option = $db->loadObjectList();
            return $option;
        }
}
