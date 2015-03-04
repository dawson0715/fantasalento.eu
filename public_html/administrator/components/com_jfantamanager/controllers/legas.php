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
			
			$model=$this->getModel();

            if($giornata==0)
                $esito = $model->CreaGiocatori();
            else
                $esito = $model->UpdateGiocatori($giornata);
             
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
		/*
		print_r($lega);exit;
		[id] => 1 [nome] => Lecce [logo] => [scontri_diretti] => 0 
		[partecipanti] => 4 [giornate] => 38 [ritardo] => 0 [crediti] => 250 
		[modificatore] => 1 [p_fissa] => 1 [sostituzioni] => 3 [ruolo] => 0 [cambi] => 15 
		[goal_at] => 0.0 [goal_range] => 0.0 )
		*/
           //CALCOLA I PUNTI DI OGNI SQUADRA
			$squadre=$model->getSquadreLega($lega->id);
			foreach ($squadre as $squadra)
			{
				$calcolo    = $model->Calcola($squadra->id,$giornata,$lega);

				$salva[$squadra->id]->punti		= $calcolo->punti;
				$salva[$squadra->id]->goal    	= $calcolo->goal;
				$salva[$squadra->id]->passato  	= $squadra->tot_punti;				
				
				if ($calcolo->punti>0)
					$txt .= "$squadra->nome:$calcolo->punti(F)<br>";
				else
					$txt .= "$squadra->nome: ERRORE <br>";
			}
			
			//Ho calcolato tutti i punti delle squadre
			//ASSEGNO I PUNTI ALLA SQUADRA			
			$scontri = $model->getScontri($giornata);
			foreach ($scontri as $scontro)
			{
				if($salva[$scontro->casa]->goal > $salva[$scontro->trasferta]->goal)
				{
					$salva[$scontro->casa]->puntidiretti = 3;
					$salva[$scontro->casa]->v = 1;
					$salva[$scontro->trasferta]->puntidiretti = 0;	
					$salva[$scontro->trasferta]->p = 1;
				}
				else if($salva[$scontro->casa]->goal < $salva[$scontro->trasferta]->goal)
				{
					$salva[$scontro->casa]->puntidiretti = 0;
					$salva[$scontro->casa]->p = 1;
					$salva[$scontro->trasferta]->puntidiretti = 3;
					$salva[$scontro->trasferta]->v = 1;
				}
				else
				{
					$salva[$scontro->casa]->puntidiretti = 1;
					$salva[$scontro->casa]->n = 1;
					$salva[$scontro->trasferta]->puntidiretti = 1;
					$salva[$scontro->trasferta]->n = 1;
				}
				$salva[$scontro->casa]->goalsubiti = $salva[$scontro->trasferta]->goal;
				$salva[$scontro->trasferta]->goalsubiti = $salva[$scontro->casa]->goal;
			}	
			
            $somma = $model->setSquadra($salva,$squadra->lega,$giornata);
			
			/*/______________ DEBUG ___________
			echo "GIORNATA" . $giornata;
			echo "SCONTRI:";print_r($scontri);
			exit;
			//___________ FINE DEBUG ___________/*/
			
			//CALCOLO LA PROSSIMA GIORNATA SE SONO FINITI I GIRONI
			if($scontri->stato == 0)
			{	$last	= $model->getLast($lega);
				if($giornata == $last)  //Ultima dei gironi
				$model->setFirst($lega);						//SET STATO A 1
			}
			else if($scontri->stato == 2) //Qualsiasi ritorni 
				$model->setOnes($scontri,$lega);		//SET STATO A 1
			else if ($scontri->stato == 1) //Qualsiasi andata
				$model->setBack($scontri,$lega); 				//SET STATO A 2
			
			$model->ufficializza($giornata,1);
			
            return 	count($squadre)." squadre della lega :$lega->nome ($diretto) per scontri diretti sono: <br>$txt<br>" .
					count($squadre)." squadre della lega :$lega->nome ($somma) per somma diretta sono: <br>$txt<br>";
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
			JError::raiseWarning(500, JText::_('COM_JFANTAMANAGER_CALENDARIOS_NO_ITEM_SELECTED'));
		} else {
                    // Get the model.
                    $model = $this->getModel();
                    
                    if (!$model->ufficializza($ids[0], $value)) {
				JError::raiseWarning(500, $model->getError());
                    } else
                        if ($value == 1){
                                $this->setMessage(JText::plural('COM_JFANTAMANAGER_CALENDARIOS_N_GIOCATA', $ids[0]));
                        } else if ($value == 0){
                                $this->setMessage(JText::plural('COM_JFANTAMANAGER_CALENDARIOS_N_UNGIOCATA', $ids[0]));
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