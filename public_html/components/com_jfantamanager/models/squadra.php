<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * HelloWorld Model
 */
class jFantaManagerModelSquadra extends JModelList
{
	/**
	 * @var string msg
	 */
	//protected $Classifca;


        protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('id,nome,pos,valore_att,valore_ini');
		// From the hello table
		$query->from('#__fanta_giocatore');
                $query->where('squadra="MILAN"');
		return $query;
	}
}