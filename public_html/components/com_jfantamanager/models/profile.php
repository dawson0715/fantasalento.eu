<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

/**
 * HelloWorld Model
 */
class jFantaManagerModelProfile extends JModelForm
{
	/**
	 * @var string msg
	 */
	protected $data;
        protected $squadra;


        public function getData()
	{
		if ($this->data === null) {

			$userId = $this->getState('user.id');

			// Initialise the table with JUser.
			$this->data	= new JUser($userId);

			// Set the base user data.
			$this->data->email1 = $this->data->get('email');
			$this->data->email2 = $this->data->get('email');

			// Override the base user data with any data in the session.
			$temp = (array)JFactory::getApplication()->getUserState('com_users.edit.profile.data', array());
			foreach ($temp as $k => $v) {
				$this->data->$k = $v;
			}

			// Unset the passwords.
			unset($this->data->password1);
			unset($this->data->password2);

			$registry = new JRegistry($this->data->params);
			$this->data->params = $registry->toArray();

			// Get the dispatcher and load the users plugins.
			$dispatcher	= JDispatcher::getInstance();
			JPluginHelper::importPlugin('user');

			// Trigger the data preparation event.
			$results = $dispatcher->trigger('onContentPrepareData', array('com_users.profile', $this->data));

			// Check for errors encountered while preparing the data.
			if (count($results) && in_array(false, $results, true)) {
				$this->setError($dispatcher->getError());
				$this->data = false;
			}
		}

		return $this->data;
	}

	/**
	 * Method to get the profile form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 * for users plugins to extend the form with extra fields.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_users.profile', 'profile', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
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
		return $this->getData();
	}

	/**
	 * Override preprocessForm to load the user plugin group instead of content.
	 *
	 * @param	object	A form object.
	 * @param	mixed	The data expected for the form.
	 * @throws	Exception if there is an error in the form event.
	 * @since	1.6
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'user')
	{
		if (JComponentHelper::getParams('com_users')->get('frontend_userparams'))
		{
			$form->loadFile('frontend',false);
			if (JFactory::getUser()->authorise('core.login.admin')) {
				$form->loadFile('frontend_admin',false);
			}
		}
		parent::preprocessForm($form, $data, $group);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		// Get the application object.
		$params	= JFactory::getApplication()->getParams('com_users');

		// Get the user id.
		$userId = JFactory::getApplication()->getUserState('com_users.edit.profile.id');
		$userId = !empty($userId) ? $userId : (int)JFactory::getUser()->get('id');

		// Set the user id.
		$this->setState('user.id', $userId);

		// Load the parameters.
		$this->setState('params', $params);
	}

	/**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function save($data)
	{
		$userId = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('user.id');

		$user = new JUser($userId);

		// Prepare the data for the user object.
		$data['email']		= $data['email1'];
		$data['password']	= $data['password1'];

		// Unset the username so it does not get overwritten
		unset($data['username']);

		// Unset the block so it does not get overwritten
		unset($data['block']);

		// Unset the sendEmail so it does not get overwritten
		unset($data['sendEmail']);

		// Bind the data.
		if (!$user->bind($data)) {
			$this->setError(JText::sprintf('USERS PROFILE BIND FAILED', $user->getError()));
			return false;
		}

		// Load the users plugin group.
		JPluginHelper::importPlugin('user');

		// Null the user groups so they don't get overwritten
		$user->groups = null;

		// Store the data.
		if (!$user->save()) {
			$this->setError($user->getError());
			return false;
		}

		return $user->id;
	}
        
        function getListaGiocatori($id)
        {
            $user = &JFactory::getUser();
            $db =& JFactory::getDBO();
            $data = date('Y-m-d');

            $query ="SELECT #__fanta_giocatore.id,#__fanta_giocatore.nome,pos,squadra,valore_acq, 
                        COUNT(*) AS P, SUM(voto) as V, SUM(totale) as T, SUM(ammonizione) AS A, SUM(espulsione) as E, SUM(assist) as Ass, SUM(goal)+SUM(rigore_segnato) as G, SUM(goal_subito ) as Gs,SUM(rigore_parato) AS Rp, SUM(rigore_sbagliato) AS Rs
                        FROM #__fanta_squadra, #__fanta_possiede, #__fanta_giocatore, #__fanta_voti AS FV
                        WHERE #__fanta_squadra.id = $id 
                        AND #__fanta_possiede.squadra_id = #__fanta_squadra.id 
                        AND #__fanta_possiede.giocatore_id = #__fanta_giocatore.id 
                        AND #__fanta_possiede.giocatore_id = FV.giocatore_id
                        AND data_ces < $data 
                        GROUP BY FV.giocatore_id
            ORDER BY pos DESC,nome ASC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        
        function getSquadra()
        {
            
            $db =& JFactory::getDBO();

            $squadra_id=JRequest::getVar('id', '');
            if($squadra_id==0 || $squadra_id=='')
            {
                $user = &JFactory::getUser();
                $query ="SELECT * FROM #__fanta_squadra WHERE created_by = $user->id";
                $db->setQuery( $query );
                $squadra = $db->loadObjectList();
                return $squadra;
            }
            else
            {
                $query ="SELECT * FROM #__fanta_squadra WHERE id = $squadra_id";
                $db->setQuery( $query );
                $squadra = $db->loadObjectList();
                return $squadra;    
            }
        }
        
        function getListaPartecipa($squadra_id)
        {
            $db =& JFactory::getDBO();
            
            $query ="SELECT * FROM #__fanta_voti_squadra WHERE squadra_id = $squadra_id ORDER BY giornata ASC";
            $db->setQuery( $query );
            $partecipa = $db->loadObjectList();
            return $partecipa;
        }
        
        function getGraficoPartecipa($squadra_id)
        {
            $db =& JFactory::getDBO();
            
            $query ="SELECT * FROM #__fanta_voti_squadra WHERE squadra_id = $squadra_id ORDER BY giornata ASC";
            $db->setQuery( $query );
            $partecipa = $db->loadObjectList();
            
            foreach ($partecipa as $giorno)
            {
                if($giorno->posizione>0)
                    $posizioni.="[$giorno->giornata, ".(9-$giorno->posizione)."],";
            }
            
            return substr($posizioni, 0, -1);
        }
        
        public function getGraficoPunti($squadra_id)
        {
            $db     =& JFactory::getDBO();
            
            $query ="SELECT punti,giornata FROM #__fanta_voti_squadra WHERE squadra_id = $squadra_id ORDER BY giornata";
            $db->setQuery( $query );
            $punti = $db->loadObjectList();
            
            foreach ($punti as $i => $punteggio)
            {
                if($punteggio->punti>0)
                {
                    $somma+=$punteggio->punti;
                    $singolo.="[$punteggio->giornata, $punteggio->punti],";
                    $media .="[$punteggio->giornata, ".round($somma/($i+1),2)."],";
                }
                
            }
            $valori['punti']=substr($singolo, 0, -1);
            $valori['media']=substr($media, 0, -1);
            return $valori;
        }

}