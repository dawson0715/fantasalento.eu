<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class jFantaManagerModelSquadra extends JModelAdmin
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
	public function getTable($type = 'Squadra', $prefix = 'jFantaManagerTable', $config = array())
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
		$form = $this->loadForm('com_jfantamanager.squadra', 'squadra',
		                        array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_jfantamanager.edit.squadra.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
        
        function Permesso($valore)
        {
            $db =& JFactory::getDBO();
            $cid = JRequest::getVar( 'cid', array(), '', 'array' );
            foreach ($cid as $id)
            {
                $query ="UPDATE #__fanta_squadra SET permesso = '$valore' WHERE id = $id";
                $db->setQuery( $query );
                $db->query();
            }
            return ;
        }
        function getLista()
        {
            $user = &JFactory::getUser();
            $db =& JFactory::getDBO();
            $squadra = JRequest::getVar('id','');
            $data = date('Y-m-d');

            $query ="SELECT #__fanta_giocatore.id,#__fanta_giocatore.nome,pos,squadra, valore_acq, data_acq,valore_ces, data_ces 
                        FROM #__fanta_squadra, #__fanta_possiede, #__fanta_giocatore 
                        WHERE #__fanta_squadra.id = $squadra
                            AND #__fanta_possiede.squadra_id = #__fanta_squadra.id 
                            AND #__fanta_possiede.giocatore_id = #__fanta_giocatore.id 
                        ORDER BY data_ces ASC, pos DESC,nome ASC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }

    function  getGiocatori($pos)
    {
        $db =& JFactory::getDBO();

        $query ="SELECT * FROM #__fanta_giocatore WHERE pos = '$pos' AND valore_att < 99 ORDER BY valore_att DESC";
        $db->setQuery( $query );
        $datigiocatore = $db->loadObjectList();
        return $datigiocatore;
    }
    function getPosizioni($pos)
    {

        $db =& JFactory::getDBO();

        $query ="SELECT * FROM #__fanta_giocatore WHERE pos = '$pos' ORDER BY nome";
        $db->setQuery( $query );
        $listas = $db->loadObjectList();
        foreach($listas as $lista) 
        {
                $options[] = JHtml::_('select.option', $lista->id, $lista->nome." (" . substr($lista->squadra, 0, 3) .")" );
        }
        return $options;
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