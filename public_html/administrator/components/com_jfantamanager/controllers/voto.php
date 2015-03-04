<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * HelloWorld Controller
 */
class jFantaManagerControllerVoto extends JControllerForm
{
    
    public function __construct($config = array())
    {
            parent::__construct($config);

            $this->registerTask('politico',	'changeBlock');
            $this->registerTask('nonpolitico',	'changeBlock');
    }

    public function getModel($name = 'Voto', $prefix = 'jFantaManagerModel')
    {
            $model = parent::getModel($name, $prefix, array('ignore_request' => true));
            return $model;
    }
    
    public function changeBlock()
    {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

            // Initialise variables.
            $giornata = JRequest::getVar('filter_giornata', '' );
            $ids	= JRequest::getVar('cid', array(), '', 'array');
            $values	= array('politico' => 1, 'nonpolitico' => 0);
            $task	= $this->getTask();
            $value	= JArrayHelper::getValue($values, $task, 0, 'int');

//            $model = $this->getModel();
//            $giornata= $model->getState('filter.giornata');
//            $this->setMessage("$ids[0] per la giornata $giornata prende voto $value");
//            $this->setRedirect( 'index.php?option=com_jfantamanager&view=voto', $msg );
//            return;
            if (empty($ids)) {
                    JError::raiseWarning(500, JText::_('COM_FANTACALCIO_VOTO_NO_ITEM_SELECTED'));
            } else {
                // Get the model.
                $model = $this->getModel();

                if (!$model->politicizza($ids[0], $giornata, $value)) {
                            JError::raiseWarning(500, $model->getError());
                } else
                    if ($value == 1){
                            $this->setMessage(JText::plural('COM_FANTACALCIO_VOTO_POLITICO', $ids[0]));
                    } else if ($value == 0){
                            $this->setMessage(JText::plural('COM_FANTACALCIO_VOTO_UNPOLITICO', $ids[0]));
                    }
            }
            $this->setRedirect( 'index.php?option=com_jfantamanager&view=voto&tmpl=component', $msg );
    }
    
    function inserisci()
    {
        $db             =& JFactory::getDBO();
        $squadra        = JRequest::getVar('pSquadra','post');
        $numgiornata    = JRequest::getVar('filter_giornata','post');
        $err = 'error';
        $db->setQuery("SELECT COUNT( * )
                        FROM `#__fanta_voti` , `#__fanta_giocatore`
                        WHERE `#__fanta_giocatore`.id = `#__fanta_voti`.giocatore_id
                        AND `squadra` = '$squadra'
                        AND giornata =$numgiornata ");
        $num_rows = $db->loadResult();
        if($num_rows > 0)
        {
            $msg = "OPERAZIONE ANNULLATA!!! <br> $num_rows giocatori del/della $squadra hanno preso voto";
            $this->setRedirect( 'index.php?option=com_jfantamanager&view=voto&tmpl=component', $msg, $err);
            return true;
        }
        if(($squadra == '') || ($numgiornata == 0))
        {
            $msg = "ERRORE GIORNATA o SQUADRA non selezinata";
            $this->setRedirect( 'index.php?option=com_jfantamanager&view=voto&tmpl=component', $msg, $err);
            return true;
        }
        else
        {
            $db->setQuery("INSERT INTO #__fanta_voti(giocatore_id,giornata,voto,totale,presente,politico)
                            SELECT id, $numgiornata, 6.0,6.0,1,1
                            FROM #__fanta_giocatore
                            WHERE squadra = '$squadra'");
            //DATI DELL GIORNATA PRECEDENTE FARE PROVE CON [LEGA 2) LECCE]
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    $msg = $db->getErrorMsg();
                    $this->setRedirect( 'index.php?option=com_jfantamanager&view=voto&tmpl=component', $msg, $err);
                    return true;
            }
            $err = '';
            $msg = "Tutti giocatori del/della $squadra hanno preso la <b><u>presenza</u></b> e il voto politico 6.";
            $this->setRedirect( 'index.php?option=com_jfantamanager&view=voto&tmpl=component', $msg, $err);
            return true;
        }

    }
    
}
