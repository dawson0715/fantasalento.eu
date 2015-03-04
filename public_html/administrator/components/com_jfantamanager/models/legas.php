<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class jFantaManagerModelLegas extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('id,nome');
		// From the hello table
		$query->from('#__fanta_lega');
		return $query;
	}
        
        function getGiorno()
        {
            $db     =& JFactory::getDBO();
            $data_fine = date('Y-m-d');

            $query ="SELECT MAX(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` < '$data_fine'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();

            return $giornata;
        }
        
}