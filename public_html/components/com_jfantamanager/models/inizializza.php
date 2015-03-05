<?php
/**
 * Hello Model for Hello World Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class jFantaManagerModelInizializza extends JModelItem
{
	
        /**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */

        function getListaP()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_giocatore WHERE pos = 'P' ORDER BY valore_att DESC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        function getListaD()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_giocatore WHERE pos = 'D' ORDER BY valore_att DESC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        function getListaC()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_giocatore WHERE pos = 'C' ORDER BY valore_att DESC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        function getListaA()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_giocatore WHERE pos = 'A' ORDER BY valore_att DESC";
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
        
        function getLegas()
        {
            $db =& JFactory::getDBO();
            $user   = &JFactory::getUser();
            
            $lega = str_replace(";", " OR id = ", $user->partecipa);
            $query ="SELECT id,nome
                        FROM #__fanta_lega
                        WHERE (id = $lega)";
            $db->setQuery( $query );
            $messages = $db->loadObjectList();
            foreach($messages as $message) 
            {
                    $options[] = JHtml::_('select.option', $message->id, $message->nome);
            }     
            return $options;
        }
        
        function getCreata()
        {
            $db     =& JFactory::getDBO();
            $user   = &JFactory::getUser();

            $query ="SELECT COUNT(*) FROM #__fanta_squadra WHERE created_by = $user->id";
            $db->setQuery( $query );
            $creata = $db->loadResult();
            return $creata;
        }
        
        function Salva($parametri,$permessi)
        {
            $db     =& JFactory::getDBO();
            $user   = &JFactory::getUser();
            $rosa=explode(",", JRequest::getVar('rosa', '' , 'post'));
            $lega=JRequest::getVar('lega', '' , 'post');
            
            if(in_array("",$rosa))
                return false;
            $resto=JRequest::getVar('resto', '' , 'post');
            if ($resto < 0)
                return false;
            $squadra->id           = "";
            $squadra->nome         = JRequest::getVar('nome', '' , 'post');
            $squadra->created_by 	= $user->id;
//            $squadra->logo 	= "";                   //text         No 	
            $squadra->cambi 	= $parametri->cambi;    //mediumint(9) 	No 	25 			
//            $squadra->tot_punti 	= $permessi['giornata']*66;//int(11) 	No 	0 			
            $squadra->bilancio 	= $resto;               //mediumint(9) 	No 	0 			
            $squadra->permesso 	= "1";                  //tinyint(1) 	No 	0 			
            $squadra->lega         = $lega;//
            $db->insertObject('#__fanta_squadra', $squadra,id);
            $squadra_id=$db->insertid();
//            return $squadra_id;
            foreach ($rosa as $indice)
            {
                $query ="SELECT valore_att FROM #__fanta_giocatore WHERE id = $indice";
                $db->setQuery( $query );
                $valore_att=$db->loadResult();
                $data->squadra_id = $squadra_id;
                $data->giocatore_id = $indice;
                $data->data_acq     = date('Y-m-d');
                $data->valore_acq   = $valore_att;
                $db->insertObject('#__fanta_possiede', $data);
                $valore+= $valore_att;
            }
            if($parametri->crediti-$somma != $resto)
            {   
                //BLOCCA UTENTE
                $db->setQuery("UPDATE `#__fanta_squadra` 
                                SET `permesso` = '2' 
                                WHERE `id` = $squadra_id LIMIT 1 ;");
                $db->query();
                //ELIMINA I DATI DELLA SQUADRA
//                $db->setQuery("DELETE FROM `#__fanta_squadra` 
//                                WHERE id = $squadra_id");
//                $db->query();
//                $db->setQuery("DELETE FROM `#__fanta_possiede` 
//                                WHERE `squadra_id` = $squadra_id");
//                $db->query();
                return false;
            }
            return true;
        }
}