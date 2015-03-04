<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * HelloWorld Model
 */
class jFantaManagerModelGiocatore extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Giocatore', $prefix = 'jFantaManagerTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_jfantamanager.giocatore', 'giocatore', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jfantamanager.edit.calendario.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
        
        function getItem()
        {
            $db = JFactory::getDBO();
            $giocatore_id = JRequest::getVar('giocatore_id','');
            $squadra_id = JRequest::getVar('squadra_id','');
            
            if ($giocatore_id=="" || $squadra_id=="")
                return "errore 0";
            //giocatore_id,data_acq,valore_acq,data_ces,valore_ces,nome,pos
            $query ="SELECT *
                        FROM `#__fanta_possiede` AS p
                        LEFT JOIN #__fanta_giocatore AS g ON (p.giocatore_id = g.id)
                        WHERE squadra_id = $squadra_id
                            AND giocatore_id = $giocatore_id";
            $db->setQuery( $query );
            $item = $db->loadObject();
            
//            foreach ($item_info as $key => $value)
//                $item->$key = $value;

            return $item;
        }
        
        function  getGiocatori($pos = '')
        {
            $db =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_giocatore WHERE pos = '$pos' ORDER BY valore_att DESC";
            $db->setQuery( $query );
            $datigiocatore = $db->loadObjectList();
            return $datigiocatore;
        }
}
