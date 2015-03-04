<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * HelloWorlds Controller
 */
class jFantaManagerControllerLegas extends JControllerAdmin
{
        public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('giocata',		'changeBlock');
		$this->registerTask('nongiocata',	'changeBlock');
	}
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Lega', $prefix = 'jFantaManagerModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
        
        public function getGiornata()
	{
            $db     =& JFactory::getDBO();
            $data_fine = date('Y-m-d');
            
            $query ="SELECT MAX(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` < '$data_fine'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();
            
            return $giornata;
	}
        
        function carica_voti()
        {   
            $db = JFactory::getDBO();
            $giornata = JRequest::getVar('giornale', '' , 'post');
            
            if ($giornata=="")
            {
                $giornata = $this->getGiornata();
            }
            
            $model=$this->getModel();
            $esito   = $model->aggiorna_fantagazzetta($giornata);
            
            if ($esito=="")
            {   
                $msg = JText::_( "Lista voti $giornata ° giornata caricata senza voti politici" );
                $this->setRedirect( 'index.php?option=com_jfantamanager', $msg );
            }else
            {
                $msg = JText::_( "Lista voti $giornata ° giornata caricata con successo <br> $esito " );
                $this->setRedirect( 'index.php?option=com_jfantamanager', $msg, 'error' );
            }
            return true;
        }
        
        function aggiorna_giocatori()
        {
            $giornata = JRequest::getVar('giornale', '' , 'post');
            
            if ($giornata=="")
            {
                $giornata = $this->getGiornata();
            }          
            $giornata=0;
            if($giornata==0)
                $esito = $this->CreaGiocatori();
            else
                $esito = $this->UpdateGiocatori($giornata);
             
            if ($esito)
            {
                $msg = JText::_( 'Lista giocatori dei '.$esito.' aggiornati con successo alla giornata '. $giornata );
                $this->setRedirect( 'index.php?option=com_jfantamanager', $msg );
            }
            else
            {
                $msg = JText::_( 'La lista giocatori '.$esito.' non è stata aggiornata alla giornata '. $giornata );
                $this->setRedirect( 'index.php?option=com_jfantamanager', $msg, 'error' );
            }
            return ;
        }
        
        function CreaGiocatori_fantagazzetta()
        {
            $db     =& JFactory::getDBO();

            $cartella_upload=JURI::root()."administrator/components/com_jfantamanager/dati/";
            $nome_file="QGG$giornata.txt";
            //RETURN $cartella_upload;
            
            $data_array = file($cartella_upload.$nome_file);
            
            preg_match_all("/<tr>(.*?)<\/tr>/ms", $data_array[0], $matches);
            if (count($matches)<=1)
                return "FILE VUOTO";
            
            return count($matches[0]);
//            $db->setQuery("DELETE FROM #__fanta_giocatori
//                            WHERE giornata = $giornata");
//            $db->query();
            
            foreach($matches[1] as $i => $riga)
            {
                preg_match_all("/<td[^>]*>(.*?)<\/td>/ms", $riga, $match);
                if(is_numeric($match[1][0]) && $match[1][3] != "6*")
                {
                    $data       =   new stdClass();
                    $data->id=$linea[1];
                    $data->pos=$linea[2];
                    $data->nome=$linea[3];
                    $data->squadra=$linea[4];
                    $data->valore_att=$linea[5];
                    $data->valore_ini=$linea[6];
                    $db->insertObject('#__fanta_giocatore', $data, 'id');
                    $politici++;
                }
            }
            return "AGGIORNATI #"+$politici;
        }
        
        function CreaGiocatori()
        {//CREA LA LISTA DEI GIOCATORI CON VALORE INIZIALE = VALORE ATTUALE

            $db = JFactory::getDBO();
            $cartella_upload=JURI::root()."administrator/components/com_jfantamanager/dati/";
            $nome_file="QGG0.txt";
            
            //if nox exist return false
            $data_array = file('http://jfantamanager.altervista.org/Fantamanager/administrator/components/com_jfantamanager/dati/FGG10.txt');
            //return count($data_array);
            
            if (count($data_array)<=1)
                return false;
            foreach($data_array as $lines)
            {
                $linea = explode('|',$lines);
                if(is_numeric($linea[1]))
                {
//                    $result.=$data->nome.$linea[5]."<br>";
                    $data       =   new stdClass();
                    $data->id=$linea[1];
                    $data->pos=$linea[2];
                    $data->nome=$linea[3];
                    $data->squadra=$linea[4];
                    $data->valore_att=$linea[5];
                    $data->valore_ini=$linea[6];
                    $db->insertObject('#__fanta_giocatore', $data, id);
                }
            }
//            return $result;
            return true;
        }
        
        function CreaGiocatoriOld()
        {//CREA LA LISTA DEI GIOCATORI CON VALORE INIZIALE = VALORE ATTUALE

            $db = JFactory::getDBO();
            $cartella_upload="http://www.fantasalento.it/administrator/components/com_jfantamanager/dati/";
            $nome_file="calciatori.txt";
            
            //if nox exist return false
            $data_array = file($cartella_upload.$nome_file);
            
            if (count($data_array)<=1)
                return false;
            foreach($data_array as $lines)
            {
                $linea = explode('|',$lines);
                if(is_numeric($linea[0]))
                {
                    if($linea[0]<200)
                        $pos="P";
                    else if($linea[0]<500)
                        $pos="D";
                    else if($linea[0]<800)
                        $pos="C";
                    else
                        $pos="A";
                    $data       =   new stdClass();
                    $data->id=$linea[0];
                    $data->pos=$pos;
                    $data->nome=str_replace('"', '',$linea[2]);
                    $data->squadra=str_replace('"', '',$linea[3]);
                    $data->valore_ini=$linea[27];
                    $data->valore_att=$linea[27];
                    $db->insertObject('#__fanta_giocatore', $data, id);
                }
            }
            return true;
        }
        
        function UpdateGiocatori($giornata)
        {//UGUALE A CREA MA NON CAMBIA IL VALORE INIZIALE
            $db = JFactory::getDBO();
                
            $cartella_upload="http://www.fantasalento.it/administrator/components/com_jfantamanager/dati/";
            $nome_file="QGG$giornata.txt";
            
            //if nox exist return false
            $data_array = file($cartella_upload.$nome_file);
                        
            if (count($data_array)<=1)
                return false;
                
            $db->setQuery(" UPDATE `#__fanta_giocatore` 
                            SET `squadra` = '',
                                `valore_att` = '99'");
            $db->query();
            foreach($data_array as $lines)
            {
                $linea = explode('|',$lines);
                if(is_numeric($linea[0]))
                {
                    $db->setQuery("UPDATE `#__fanta_giocatore` 
                                    SET `squadra` = '". str_replace('"', '',$linea[3]) ."',
                                        `valore_att` = '$linea[4]' 
                                    WHERE `#__fanta_giocatore`.`id` = $linea[0] LIMIT 1 ;");
                    $conta++;
                    $db->query();
                    if($db->getAffectedRows()==0)
                    {
                        $data       =   new stdClass();
                        $data->id=$linea[0];
                        $data->pos=$linea[1];
                        $data->nome=$linea[2];
                        $data->squadra=$linea[3];
                        $data->valore_att=$linea[4];
                        $data->valore_ini=$linea[5];
                        $db->insertObject('#__fanta_giocatore', $data, id);
                    }
                }
            }
            return $conta;
        }
        
        function recupera($lega_id = 0)
        {
            $model=$this->getModel();
            $lega_id = JRequest::getVar('filter_lega', '' );
            $giornata = $this->getGiornata();
            
            if($lega_id>0 && $lega_id!='')//calcola solo quelli di questa lega
            {
                $lega   = $model->getLega($lega_id);
                $result = $this->RecuperaLega($lega,$giornata);
            }
            else
            {
                $legas  = $model->getLegas();
                foreach ($legas as $key => $lega) 
                    $result.= $this->RecuperaLega($lega,$giornata);
            }
            $msg = JText::_( $result );
            $this->setRedirect( 'index.php?option=com_jfantamanager', $msg );    
            return;  
        }
        
        function RecuperaLega($lega,$giornata)
        {
            $model=$this->getModel();
            $squadre=$model->getNonConsegnate($lega->id,$giornata);
            
            foreach ($squadre as $squadra)
            {
                $txt .= ($model->recupera($squadra->id,$giornata))?"$squadra->nome <br>":"ERRORE $squadra->nome";
            }
            return count($squadre) . " risultato recupero $giornata giornata:$lega->nome<br>$txt<br>";
        }
        
        function calcola($lega_id = 0)
        {
            $model=$this->getModel();
            $giornata = JRequest::getVar('giornale', '' , 'post');
            $lega_id = JRequest::getVar('filter_lega', '' );
            
            if ($giornata=="")
            {
                $giornata = $this->getGiornata();
            }
            
            if($lega_id>0 && $lega_id!='')//calcola solo quelli di questa lega
            {
                $lega   = $model->getLega($lega_id);
                $result = "p:$lega->p_fissa s:$lega->sostituzioni m:$lega->modificatore" .$this->calcolaLega($lega,$giornata);
            }
            else
            {
                $legas  = $model->getLegas();
                foreach ($legas as $key => $lega) 
                    $result.= "p:$lega->p_fissa s:$lega->sostituzioni m:$lega->modificatore" .$this->calcolaLega($lega,$giornata);
            }
            $msg = JText::_( $result );
            $this->setRedirect( 'index.php?option=com_jfantamanager', $msg );    
            return;  
        }
        
        function CalcolaLega($lega,$giornata)
        {
            $model=$this->getModel();
            $squadre=$model->getSquadreLega($lega->id);
            if(0)//$lega->p_fissa==1)
                foreach ($squadre as $squadra)
                {
                    $calcolo    = $model->CalcolaFissa($squadra->id,$giornata,$lega->sostituzioni,$lega->modificatore);
//                    if ($calcolo->punti==0)
//                    {
//                        //INSERISCO IN fantavoti_squadra  COPIA IN IMPIEGA
                        $model->Recupera($squadra->id,$giornata);
//                        $calcolo    = $model->CalcolaFissa($squadra->id,$giornata,$lega->sostituzioni,$lega->modificatore);
//                    }
                    $salva[$squadra->id]->punti    = $calcolo->punti;
                    $salva[$squadra->id]->passato    = $squadra->tot_punti;
                    if ($calcolo->punti>0)
                        $txt .= "$squadra->nome:$calcolo->punti(F)<br>";
                    else
                        $txt .= "$squadra->nome: ERRORE <br>";
                }
            else
                foreach ($squadre as $squadra)
                {
                    $calcolo    = $model->CalcolaMobile($squadra->id,$giornata,$lega->sostituzioni,$lega->modificatore);//($squadra->id,2,$lega->sostituzioni,$lega->modificatore);
//                    if ($calcolo->punti==0)
//                    {
//                        $calcolo    = $model->CalcolaMobile($squadra->id,$giornata,$lega->sostituzioni,$lega->modificatore);
//                    }
                    $salva->punti[$squadra->id]    = $calcolo->punti;
                    $salva->giornata=$giornata;
                    if ($calcolo->punti>0)
                        $txt .= "$squadra->nome:$calcolo->punti(M) $recupero<br>";
                    else
                        $txt .= "$squadra->nome: ERRORE $recupero<br>";
                }
            $ok = $model->setSquadra($salva,$squadra->lega);
            return count($squadre)." squadre della lega:$lega->nome sono: $ok <br>$txt<br>";
        }
        

        
        public function changeBlock()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('giocata' => 1, 'nongiocata' => 0);
		$task	= $this->getTask();
                $value	= JArrayHelper::getValue($values, $task, 0, 'int');
                
//                $this->setMessage("$ids[0]) $value");
//                $this->setRedirect( 'index.php?option=com_jfantamanager&view=calendarios', $msg );
//                return;
		if (empty($ids)) {
			JError::raiseWarning(500, JText::_('COM_FANTACALCIO_CALENDARIOS_NO_ITEM_SELECTED'));
		} else {
                    // Get the model.
                    $model = $this->getModel();
                    
                    if (!$model->ufficializza($ids[0], $value)) {
				JError::raiseWarning(500, $model->getError());
                    } else
                        if ($value == 1){
                                $this->setMessage(JText::plural('COM_FANTACALCIO_CALENDARIOS_N_GIOCATA', $ids[0]));
                        } else if ($value == 0){
                                $this->setMessage(JText::plural('COM_FANTACALCIO_CALENDARIOS_N_UNGIOCATA', $ids[0]));
                        }

		}
                $this->setRedirect( 'index.php?option=com_jfantamanager&view=calendarios', $msg );
	}
        
        
//        function giocata()
//        {
//            $ids	= JRequest::getVar('cid', array(), '', 'array');
//            $msg = JText::_( "Giocata ".count($ids) );
//            $this->setRedirect( 'index.php?option=com_jfantamanager&view=calendarios', $msg );
//            return;
//        }
//        
//        function nongiocata()
//        {
//            $ids	= JRequest::getVar('cid', array(), '', 'array');
//            $msg = JText::_( 'Non giocata' );
//            $this->setRedirect( 'index.php?option=com_jfantamanager&view=calendarios', $msg, 'error' );
//            return;
//        }
}

