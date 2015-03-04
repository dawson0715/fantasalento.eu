<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class jFantaManagerModelVoto extends JModelList
{
    
        protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');
                
		$giornata = $this->getUserStateFromRequest($this->context.'.filter.giornata', 'filter_giornata', '');
		$this->setState('filter.giornata', $giornata);

		// List state information.
		parent::populateState();
	}
        
        protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.giornata');

		return parent::getStoreId($id);
	}
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
                
                $giornata = $this->getState('filter.giornata');
                if ($giornata == "" || $giornata == 0)
                {
                    $giornata = $this->getGiornata();    
                    $this->setState('filter.giornata',$giornata);
                }
                
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		// From the hello table
		$query->from('#__fanta_voti AS v, #__fanta_giocatore AS g');
                $query->where('v.giocatore_id = g.id');
                $query->where("giornata = $giornata");
                $query->where("politico = 1");
		return $query;
	}
        
        function getOptions()
        {
            $db = JFactory::getDBO();
            $data = date('Y-m-d');
            $query = $db->getQuery(true);
            $query->select('giornata');
            $query->from('#__fanta_calendario');
            $query->where("data < '$data'");
            $db->setQuery((string)$query);
            $messages = $db->loadObjectList();
            $options = array();
            foreach($messages as $message) 
            {
                    $options[] = JHtml::_('select.option', $message->giornata, $message->giornata);
            }            
            return $options;
        }
        
        function politicizza($id,$giornata,$value)
        {
            $db     =& JFactory::getDBO();
            
            $db->setQuery("UPDATE `#__fanta_voti` 
                            SET presente = $value
                            WHERE giocatore_id = $id
                              AND `giornata` = $giornata");
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return $db->getErrorMsg();
            }
            return true;
        }
        
        function getGiornata()
        {
            $db     =& JFactory::getDBO();
            $data = date('Y-m-d');

            $query ="SELECT MAX(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` < '$data'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();

            return $giornata;
        }
        
        function getSquadras()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT DISTINCT squadra as text FROM #__fanta_giocatore ORDER BY text";
            $db->setQuery( $query );
            $option = $db->loadObjectList();
            return $option;
        }
}