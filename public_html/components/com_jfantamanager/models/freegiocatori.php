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
            $data = date('Y-m-d');

            $query ="SELECT G.id,G.nome,G.pos,G.squadra FROM #__fanta_giocatore as G LEFT JOIN #__fanta_possiede as P ON(P.giocatore_id = G.id)  WHERE P.giocatore_id IS NULL AND pos = '$pos' ORDER BY pos DESC,nome ASC";
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
