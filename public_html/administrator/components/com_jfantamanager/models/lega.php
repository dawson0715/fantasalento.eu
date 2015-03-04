<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class jFantaManagerModelLega extends JModelAdmin
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
	public function getTable($type = 'Lega', $prefix = 'jFantaManagerTable', $config = array())
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
		$form = $this->loadForm('com_jfantamanager.lega', 'lega',
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
		$data = JFactory::getApplication()->getUserState('com_jfantamanager.edit.lega.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
        
        function ufficializza($id, $value)
        {
            $db     =& JFactory::getDBO();
            
            $db->setQuery("UPDATE `#__fanta_calendario` 
                            SET giocata = $value 
                            WHERE `giornata` = $id");
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return $db->getErrorMsg();
            }
            return true;
        }
        
        function CalcolaFissa($giornata,$squadra,$sostituzioni,$modificatore)
        {
            $db     =& JFactory::getDBO();
            $punteggio->punti=0;
            $miss = array("P" => 11,"D" => 12,"C" => 13,"A" => 14);

            $query ="SELECT * FROM `#_fanta_impiega`
                        LEFT JOIN #__fanta_voti ON
                            (#__fanta_impiega.giocatore_id=#__fanta_voti.giocatore_id AND #__fanta_impiega.giornata = #__fanta_voti.giornata )
                        LEFT JOIN #__fanta_giocatore ON
                            (#__fanta_voti.giocatore_id = #__fanta_giocatore.id)
                        WHERE #__fanta_impiega.`squadra_id`= $squadra 
                            AND #__fanta_impiega.`giornata` = $giornata
                        ORDER BY riserva ASC, pos DESC";
            $db->setQuery( $query );
            $giocatore = $db->loadObjectList();
            for($i=0;$i<11;$i++)
            {
                $indice=$miss[$giocatore[$i]->pos];
                if ($giocatore[$i]->presente)
                {
                    $punteggio->punti+=$giocatore[$i]->totale;
                    $punteggio->rosa[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                }
                elseif($sostituzioni>0)
                    if(($giocatore[$indice]->presente))
                    {//li inserisco dalla panchina  (1 scelta)
                        $punteggio->punti+=$giocatore[$indice]->totale;
                        $giocatore[$indice]->presente=0;
                        $sostituzioni--;
                        $punteggio->rosa[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                    }
                    elseif(($giocatore[$indice+3]->presente) && ($giocatore[$i]->pos!='P'))
                    {
                        //li inserisco dalla 2 scelta della panchina                   
                        $punteggio->punti+=$giocatore[$indice+3]->totale;
                        $giocatore[$indice+3]->presente=0;
                        $sostituzioni--;
                        $punteggio->rosa[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                    }
            }
            if($modificatore && count($punteggio->rosa['D'])>3)
            {
                $punteggio->modificatore =  $this->CalcolaModificatore($punteggio->rosa);
                $punteggio->punti+=$punteggio->modificatore;
            }
            return $punteggio;
        }
        
        function CalcolaMobile($id,$giornata,$sostituzioni,$modificatore)
        {
            $db     =& JFactory::getDBO();
            
            $punteggio->punti=0;
            $punteggio->conta=0;
            $max = array("P" => 1,"D" => 5,"C" => 5,"A" => 3);
            $min = array("P" => 1,"D" => 3,"C" => 3,"A" => 1);
            
            $query ="SELECT * FROM `#__fanta_impiega`
                        LEFT JOIN #__fanta_giocatore ON
                            (#__fanta_impiega.giocatore_id = #__fanta_giocatore.id)
                        LEFT JOIN #__fanta_voti ON
                            (#__fanta_impiega.giocatore_id=#__fanta_voti.giocatore_id AND #__fanta_impiega.giornata = #__fanta_voti.giornata )
                        WHERE #__fanta_impiega.`squadra_id`= $id 
                            AND #__fanta_impiega.`giornata` = $giornata
                        ORDER BY riserva ASC, pos DESC";
            $db->setQuery( $query );
            $giocatore = $db->loadObjectList();
            for($i=0;$i<11;$i++)
            {
                $punteggio->rosa[$i]=$giocatore[$i];
                if ($giocatore[$i]->presente)
                {
                    $punteggio->stato[$i]="in";
                    $punteggio->punti+=$giocatore[$i]->totale;
                    $min[$giocatore[$i]->pos]--;
                    $max[$giocatore[$i]->pos]--;
                    $list_modificatore[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                    $punteggio->conta++;
                }
                else
                {
                    $panchina[]=$giocatore[$i]->pos;
                    $punteggio->stato[$i]="out";
                }
            }
            for($i=11;$i<18;$i++)
                $punteggio->rosa[$i]=$giocatore[$i];
            $punteggio->panchina=$panchina;
            foreach($panchina as $manca) //cerco lo stesso ruolo
            {
                $i=11;
                $trovato=false;
                while(($i<18) && (!$trovato) && ($punteggio->conta<11) && ($sostituzioni>0))
                {
                    if(($giocatore[$i]->presente) && ($giocatore[$i]->pos==$manca))
                    {
                        $manca='';
                        $punteggio->stato[$i]="in";
                        $max[$giocatore[$i]->pos]--;
                        $punteggio->punti+=$giocatore[$i]->totale;
                        $giocatore[$i]->presente=0;
                        $sostituzioni--; 
                        $trovato=true;
                        $list_modificatore[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                        $punteggio->conta++;
                    }
                    $i++;
                }
            }
            ///MODIFCATORE FOMAZIONE IN CAMPO
            if($min["P"]>0) $punteggio->conta+=$min["P"];
            if($min["D"]>0) $punteggio->conta+=$min["D"];
            if($min["C"]>0) $punteggio->conta+=$min["C"];
            if($min["A"]>0) $punteggio->conta+=$min["A"];
            $i=11;
            while(($i<18) && ($sostituzioni>0) && $punteggio->conta<11)
            {
                if(($giocatore[$i]->presente) && ($max[$giocatore[$i]->pos]>0))
                {
                    $punteggio->stato[$i]="in";
                    $punteggio->punti+=$giocatore[$i]->totale;
                    $giocatore[$i]->presente=0;
                    $max[$giocatore[$i]->pos]--;
                    $sostituzioni--;
                    $list_modificatore[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                    $punteggio->conta++;
                }
                $i++;
            }
            if($modificatore && count($list_modificatore['D'])>3)
            {
                $punteggio->modificatore =  $this->CalcolaModificatore($list_modificatore);
                $punteggio->punti+=$punteggio->modificatore;
            }
            $punteggio->goal = ($punteggio->punti<60)?0:floor(($punteggio->punti - 55.5)/5);
            return $punteggio;
        }
        
        function CalcolaModificatore($list_modificatore)
        {
            $bonus="";
            rsort($list_modificatore['D']);
            $media=($list_modificatore['P'][0]+$list_modificatore['D'][0]+$list_modificatore['D'][1]+$list_modificatore['D'][2])/4;
            if($media < 6)
                $bonus=0;
            else if($media < 6.5)
                $bonus=1;
            else if($media < 7)
                $bonus=3;
            else
                $bonus=6;
            return $bonus;
        }
        
        function Calcola_Mobile_no_modifica_formaz($giornata,$squadra,$sostituzioni,$modificatore)
        {
            
            $db     =& JFactory::getDBO();
            $punteggio->punti=0;
            $max = array("P" => 1,"D" => 5,"C" => 5,"A" => 3);
            $min = array("P" => 1,"D" => 3,"C" => 3,"A" => 1);
            
            $query ="SELECT * FROM `#__fanta_impiega`
                        LEFT JOIN #__fanta_voti ON
                            (#__fanta_impiega.giocatore_id=#__fanta_voti.giocatore_id AND #__fanta_impiega.giornata = #__fanta_voti.giornata )
                        LEFT JOIN #__fanta_giocatore ON
                            (#__fanta_voti.giocatore_id = #__fanta_giocatore.id)
                        WHERE #__fanta_impiega.`squadra_id`= $squadra 
                            AND #__fanta_impiega.`giornata` = $giornata
                        ORDER BY riserva ASC, pos DESC";
            $db->setQuery( $query );
            $giocatore = $db->loadObjectList();
            for($i=0;$i<11;$i++)
                if ($giocatore[$i]->presente)
                {
                    $rosa[]=$giocatore[$i]->nome;
                    $punteggio->punti+=$giocatore[$i]->totale;
                    $min[$giocatore[$i]->pos]--;
                    $max[$giocatore[$i]->pos]--;
                    $punteggio->rosa[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                }
            foreach($min as $pos=>$usato)
                if(($usato>0) && ($sostituzioni>0))
                {
                    $i=11;
                    $trovato=false;
                    while(($i<17) && (!$trovato))
                    {
                        if(($giocatore[$i]->presente) && ($giocatore[$i]->pos==$pos))
                        {
                            $rosa[]=$giocatore[$i]->nome;
                            $max[$giocatore[$i]->pos]--;
                            $punteggio->punti+=$giocatore[$i]->totale;
                            $giocatore[$i]->presente=0;
                            $sostituzioni--; 
                            $trovato=true;
                            $punteggio->rosa[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                        }
                        $i++;
                    }
                }
            $i=11;
            while(($i<18) && ($sostituzioni>0))
            {
                if(($giocatore[$i]->presente) && ($max[$giocatore[$i]->pos]>0))
                {
                    $punteggio->punti+=$giocatore[$i]->totale;
                    $giocatore[$i]->presente=0;
                    $max[$giocatore[$i]->pos]--;
                    $sostituzioni--;
                    $punteggio->rosa[$giocatore[$i]->pos][]=$giocatore[$i]->voto;
                }
                $i++;
            }
            if($modificatore)
                $punteggio->modificatore=calcolaModificatore($punteggio->rosa);
            return $punteggio;
        }
        
        function aggiorna_fantagazzetta($giornata)
        {
            $db     =& JFactory::getDBO();

            $cartella_upload=JURI::root()."administrator/components/com_jfantamanager/dati/";
            $nome_file="FGG$giornata.txt";
            
            $data_array = file($cartella_upload.$nome_file);
            //print_r($data_array[0]);

            preg_match_all("/<tr>(.*?)<\/tr>/ms", $data_array[0], $matches);
            if (count($matches)<=1)
                return false;
            
            $db->setQuery("DELETE FROM #__fanta_voti
                            WHERE giornata = $giornata");
            $db->query();
            
            foreach($matches[1] as $i => $riga)
            {
                preg_match_all("/<td[^>]*>(.*?)<\/td>/ms", $riga, $match);
                if(is_numeric($match[1][0]) && $match[1][3] != "6*")
                {
                    $data                   = new stdClass();
                    $data->giocatore_id     = $match[1][0];//0  Cod.
                    $data->giornata     = $giornata;
                    //$data->id=$match[1][1];//1  Ruolo
                    //$data->id=$match[1][2];//2  Nome
                    $data->voto             = round(str_replace(",", '.', $match[1][3]),1);//3  VF
                    $data->goal             = strip_tags($match[1][4]);//4  Gol Fatto
                    $data->goal_subito      = strip_tags($match[1][5]);//5  Gol Subito
                    $data->rigore_parato    = strip_tags($match[1][6]);//6  Rigore Parato
                    $data->rigore_sbagliato = strip_tags($match[1][7]);//7  Rigore Sbagliato
                    $data->rigore_segnato   = strip_tags($match[1][8]);//8  Rigore Segnato
                    $data->autorete         = strip_tags($match[1][9]);//9  Autorete
                    $data->ammonizione      = strip_tags($match[1][10]);//10 Ammonizione
                    $data->espulsione       = strip_tags($match[1][11]);//11 Espulsione
                    $data->assist           = strip_tags($match[1][12]);//12 Assist 
                    $data->presente         = 1;//12 Assist 
                    $malus = ($data->espulsione)?1:$data->ammonizione*0.5;
                    $data->totale           = ($data->voto + $data->goal*3 + $data->rigore_segnato*3 + $data->rigore_parato*3 + $data->assist) - ($data->goal_subito + $data->rigore_sbagliato*3 + $data->autorete*2 + $malus);
                    $db->insertObject('#__fanta_voti', $data);
                }
                else if ($match[1][3] == "6*")
                {
                    $politici .= $match[1][1].") ".$match[1][2]."<br>";
                    $data                   = new stdClass();
                    $data->giocatore_id     = $match[1][0];//0  Cod.
                    $data->giornata         = $giornata;
                    $data->voto             = 6.0;
                    $data->totale           = 6.0;
                    $data->presente         = 0;
                    $data->politico         = 1;
                    $db->insertObject('#__fanta_voti', $data);
                }
            }
            return $politici;
        }
        
        function aggiorna_voti()
        {   
            $db = JFactory::getDBO();
            $giornata = $this->getGiornata();
            
            $cartella_upload="http://www.fantasalento.it/administrator/components/com_jfantamanager/dati/";
            $nome_file="FGG$giornata.txt";
                       
            $data_array = file($cartella_upload.$nome_file);
            if (count($data_array)<=1)
            {
                $msg = JText::_( $cartella_upload.$nome_file.'<br>File non esiste' );
                $this->setRedirect( 'index.php?option=com_jfantamanager', $msg,'error' );
                return;
            }
            $db->setQuery("DELETE FROM `#__fanta_voti` WHERE `giornata` = $giornata");
            $db->query();
            
            foreach($data_array as $lines)
            {
                $linea = explode('|',$lines);
                if(is_numeric($linea[0]))
                {
                    $voto       =   new stdClass();
                    $voto->giocatore_id=$linea[0];
                    $voto->giornata=$giornata;
                    $voto->presente=$linea[6];
                    if($linea[6])
                    {
                        $voto->voto=$linea[10];
                        $voto->goal=$linea[12];
                        $voto->ammonizione=$linea[17];
                        $voto->espulsione=$linea[18];
                        $voto->assist=$linea[16];
                        $voto->totale=$linea[7];
                        $voto->goal_subito=$linea[13];
                        $voto->rigore_parato=$linea[21];
                        $voto->rigore_sbagliato=$linea[22];
                        $voto->rigore_segnato=$linea[0];
                        $voto->autorete=$linea[23]; 
                    }
                    $db->insertObject('#__fanta_voti', $voto, giocatore_id,giornata);
                    
//                    $gioco->id=$linea[0];
//                    $gioco->pos=$pos;
//                    $gioco->nome=str_replace('"', '',$linea[2]);
//                    $gioco->squadra=str_replace('"', '',$linea[3]);
//                    $gioco->valore_att=$linea[27];
                    $db->setQuery("UPDATE `#__fanta_giocatore` 
                                    SET `valore_att` = '$linea[27]' 
                                    WHERE `#__fanta_giocatore`.`id` = $linea[0] LIMIT 1 ;");
                    $db->query();
                    //$db->insertObject('#__fanta_giocatore', $gioco, id);
                }
            }
            $msg = JText::_( "Lista voti giornata $giornata aggiornata con successo" );
            $this->setRedirect( 'index.php?option=com_jfantamanager', $msg );
            return true;
        }
        
        public static function getLega($lega_id)
	{
            $db     =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_lega WHERE id = 2";//$user->partecipa)";
            $db->setQuery( $query );
            $lega=$db->loadObject();

            return $lega;
	}
        
        public static function getLegas()
	{
            $db     =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_lega";//$user->partecipa)";
            $db->setQuery( $query );
            $legas=$db->loadObjectList();

            return $legas;
	}
        
        public static function getSquadreLega($lega)
	{
            $db     =& JFactory::getDBO();

            $query ="SELECT * FROM #__fanta_squadra WHERE lega = $lega";//$user->partecipa)";
            $db->setQuery( $query );
            $squadre=$db->loadObjectList();

            return $squadre;
	}
        
        public static function getNonConsegnate($lega,$giornata)
	{
            $db     =& JFactory::getDBO();

            $query ="SELECT DISTINCT id, nome
                        FROM #__fanta_squadra
                        WHERE lega = $lega
                        AND id NOT
                        IN (SELECT squadra_id
                            FROM #__fanta_voti_squadra
                            WHERE giornata = $giornata)
            ";//$user->partecipa)";
            $db->setQuery( $query );
            $squadre=$db->loadObjectList();

            return $squadre;
	}
        
        public static function getGiornata()
        {
            $db     =& JFactory::getDBO();
            $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));

            $query ="SELECT MIN(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` >= '$data_fine'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();

            return $giornata;
        }
        
        function recupera($squadra_id,$numgiornata)
        {
            $db     =& JFactory::getDBO();
            $data       =   new stdClass();
            $data->squadra_id = $squadra_id;
            $data->giornata = $numgiornata;
            $db->insertObject('#__fanta_voti_squadra', $data, id);
            $db->setQuery("INSERT INTO #__fanta_impiega(squadra_id,giocatore_id,giornata,riserva)
                                SELECT squadra_id, giocatore_id, $numgiornata, riserva
                                FROM #__fanta_impiega
                                WHERE squadra_id = $squadra_id
                                    AND giornata = " . ($numgiornata-1));
            //DATI DELL GIORNATA PRECEDENTE FARE PROVE CON [LEGA 2) LECCE]
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return $db->getErrorMsg();
            }
            return true;
        }
        
        function setSquadra($salva,$lega)
        {
            $db     =& JFactory::getDBO();
            $db->setQuery("SELECT SUM(punti) as punti,squadra_id
                            FROM `#__fanta_voti_squadra`
                            LEFT JOIN #__fanta_squadra ON (`#__fanta_voti_squadra`.squadra_id = #__fanta_squadra.id)
                            WHERE `giornata`< $salva->giornata
                            AND lega = $lega
                            GROUP BY `squadra_id` 
                ");
            $punti = $db->loadObjectList();
            if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return false;
            }
            
            foreach ($punti as $value)
                $value->punti +=$salva->punti[$value->squadra_id];
            
            rsort($punti);
            
//            foreach ($punti as $id => $value)
//                $ok .= "$id ) $value->squadra_id - $value->punti <br>" ;
                
//            return $ok;
            
            foreach ($punti as $id => $punteggio)
            {
                $db->setQuery(
                    "UPDATE `#__fanta_voti_squadra`
                     SET punti = ".$salva->punti[$punteggio->squadra_id].",
                         posizione =    ".($id+1)."
                     WHERE squadra_id  = $punteggio->squadra_id
                     AND giornata = $salva->giornata
                ");
                if (!$db->query()) {
                        $this->setError($db->getErrorMsg());
                        return false;
                }
//                $db->setQuery("UPDATE `#__fanta_squadra`
//                     SET tot_punti = $punteggio->punti
//                     WHERE id  = $punteggio->squadra_id");
//                if (!$db->query()) {
//                        $this->setError($db->getErrorMsg());
//                        return false;
//                }
            }
            
//            return $ok;
            return true;
        }
}