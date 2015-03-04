<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class jFantaManagerModelSquadras extends JModelList
{
    
        protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');
                
		$page = $this->getUserStateFromRequest($this->context.'.filter.lega', 'filter_lega', '');
		$this->setState('filter.lega', $page);

		// List state information.
		parent::populateState();
	}
        
        protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.lega');

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
                
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		// From the hello table
		$query->from('#__fanta_squadra');
                
                $page = $this->getState('filter.lega');
                if ($page!='')
                    $query->where('lega = ' . $db->quote($page));
                
		// Filter on the language.
		//if ($page!='') {
		//	$query->where('lega = ' . $db->quote($page));
		//}
                
                
		return $query;
	}
        
        function getOptions()
        {
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('id,nome');
            $query->from('#__fanta_lega');
            $db->setQuery((string)$query);
            $messages = $db->loadObjectList();
            $options = array();
            foreach($messages as $message) 
            {
                    $options[] = JHtml::_('select.option', $message->id, $message->nome);
            }            
            return $options;
        }
}