<?php
/**
 * @version		$Id: users.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Users component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6
 */
class jFantaManagerHelper
{
	/**
	 * @var		JObject	A cache for the available actions.
	 * @since	1.6
	 */
        protected static $id;
        protected static $parametri;
        protected static $permessi;
//	protected static $nome;
//        protected static $logo;
//        protected static $scontri_diretti;
//        protected static $partecipanti;
//        protected static $giornate;
//        protected static $ritardo;
//        protected static $crediti;
//        protected static $modificatore;
//        protected static $p_fissa;
//        protected static $p_numero;
//        protected static $sostituzioni;
//        protected static $ruolo;
//        protected static $cambi;
        
        public static function getGiornata()
	{
            $db     =& JFactory::getDBO();
            $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));
            
            $query ="SELECT MIN(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` >= '$data_fine'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();
            
            return $giornata;
	}
    
	function getGiornataN($giornata)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('MIN(giornata) ');
		$query->from('#__fanta_scontri');
		$query->where("giornata >= $giornata ");
		$db->setQuery( $query );
		return $db->loadResult();
	}
	
    public static function getIdSquadra()
	{
            $db     =& JFactory::getDBO();
            $user   = &JFactory::getUser();
                
            $query ="SELECT id
                    FROM #__fanta_squadra
                    WHERE created_by = $user->id";
            $db->setQuery( $query );
            $id = $db->loadResult();
            return $id;
	}
        
        public static function getIdCampionato()
	{
            if(!isset($id))
            {
                $user = &JFactory::getUser();

                $query ="SELECT lega
                        FROM #__fanta_squadra
                        WHERE created_by = $user->id";
                $db->setQuery( $query );
                $id = $db->loadResult();
            }       
            return $id;
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getParameters($lega)
	{
                $db     =& JFactory::getDBO();
                
                $query ="SELECT * FROM #__fanta_lega WHERE id = $lega";
                $db->setQuery( $query );
                $parametri=$db->loadObject();
                    
		return $parametri;
	}
        
        public static function getFirstParameters()
	{
                $db     =& JFactory::getDBO();
                $user = &JFactory::getUser();
                
                $query ="SELECT * FROM #__fanta_lega WHERE id = 1";//$user->partecipa)";
                $db->setQuery( $query );
                $parametri=$db->loadObject();
                    
		return $parametri;
	}
        
        public static function getPermessi()
        {
            $user = &JFactory::getUser();
            $db =& JFactory::getDBO();

            $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));

            $query ="SELECT permesso FROM #__fanta_squadra WHERE created_by = $user->id";
            $db->setQuery( $query );
            $permessi['permesso'] = $db->loadResult();

            $query ="SELECT MIN(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` >= '$data_fine'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();

            $query ="SELECT * FROM #__fanta_calendario WHERE giornata = $giornata";
            $db->setQuery( $query );
            $temp=$db->loadAssoc();
            $permessi['giornata']=$temp['giornata'];
            $permessi['data']=$temp['data'];
            $permessi['ora']=$temp['ora'];
            $permessi['giocata']=$temp['giocata'];

            $query ="SELECT COUNT(*) FROM `#__fanta_impiega` WHERE `squadra_id`= (SELECT id
                    FROM #__fanta_squadra
                    WHERE created_by = $user->id)
                    AND `giornata` = $giornata";
            $db->setQuery( $query );
            $permessi['inserita'] = $db->loadResult();

            return $permessi;
            //($result)->fanta_allow;
        }
        
	/**
	 * Get a list of filter options for the blocked state of a user.
	 *
	 * @return	array	An array of JHtmlOption elements.
	 * @since	1.6
	 */
	static function getStateOptions()
	{
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '0', JText::_('JENABLED'));
		$options[]	= JHtml::_('select.option', '1', JText::_('JDISABLED'));

		return $options;
	}

	function getConsegnateList()
        {

            $db =& JFactory::getDBO();
            $giornata   = jFantaManagerHelper::getGiornata();
            
            $query ="SELECT id,nome,data,ora FROM #__fanta_voti_squadra LEFT JOIN #__fanta_squadra ON (#__fanta_voti_squadra.squadra_id = #__fanta_squadra.id) WHERE giornata=$giornata AND lega = 1";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            foreach ($datisquadra as $i => $squadra) {
                $result[$i]['dati']=$squadra;
                $query ="SELECT nome,pos
                        FROM #__fanta_impiega 
                        LEFT JOIN #__fanta_giocatore
                            ON (#__fanta_impiega.giocatore_id = #__fanta_giocatore.id)
                        WHERE giornata=$giornata AND squadra_id=$squadra->id
                        ORDER BY riserva ASC, pos DESC";
                        $db->setQuery( $query );
                        $result[$i]['lista'] = $db->loadObjectList();
            }
            //LEFT JOIN #__fanta_impiega LEFT JOIN #__fanta_giocatore
            return $result;
        }
}