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
	
   function Calcola($id,$giornata,$lega)
   {
	    $sostituzioni = $lega->sostituzioni;
	    $modificatore = $lega->modificatore;
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
					$manca = '';
					$punteggio->stato[$i]="in";
					$max[$giocatore[$i]->pos]--;
					$min[$giocatore[$i]->pos]--;
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
		////MODIFCATORE FOMAZIONE IN CAMPO
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
			$bonus="";
			rsort($list_modificatore['D']);
			$media=($list_modificatore['P'][0]+$list_modificatore['D'][0]+$list_modificatore['D'][1]+$list_modificatore['D'][2])/4;
			if($media < 6)
				$bonus=0;
			else if($media < 6.5)
				$bonus=1;
		
			elseif($media < 7)
				$bonus=3;
			else
				$bonus=6;
			$punteggio->punti+=$bonus;
			$punteggio->modificatore =  $bonus;
		}		
		$punteggio->goal = $this->CalcolaGoal($punteggio->punti,$lega);
		
		return $punteggio;
	}
		
	function aggiorna_fantagazzetta($giornata)
	{
		$db     =& JFactory::getDBO();

		$nome_file="FGG$giornata.txt";
		$cartella_upload=JURI::root()."administrator/components/com_jfantamanager/dati/";
		$cartella_download = "http://jfantamanager.altervista.org/administrator/components/com_jfantamanager/dati/";
		
		$data_array = file($cartella_upload.$nome_file);
		/*
		$data_array = file($cartella_download.$nome_file);
		if(count($data_array)==0)
			$data_array = file($cartella_upload.$nome_file);
		else
			$politici="<br>FILE CARICATO CON SUCCESSO<br><br>";
		*/
		
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
				$data->assist           = strip_tags($match[1][12]);//12 Assist ($match[1][12] != 0)?1:0;//
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

	function UpdateGiocatori($giornata)
	{//UGUALE A CREA MA NON CAMBIA IL VALORE INIZIALE
		$db = JFactory::getDBO();
			
		$cartella_upload	= JURI::root()."administrator/components/com_jfantamanager/dati/";
		$nome_file			= "calciatori.txt";
		
		$data_array = file_get_contents($cartella_upload.$nome_file);
		$data_array = str_replace("</th></tr>","</td></tr>",$data_array);
		$data_array = str_replace("<tr><td>","",$data_array);
		$data_array = str_replace("</td><td>","|",$data_array);
		$data_array = str_replace(",",".",$data_array);
		$temp=explode("</td></tr>",$data_array);

		$db->setQuery("UPDATE `#__fanta_giocatore` SET `squadra` = '', `valore_att` = '99'");
		$db->query();
		
		foreach($temp as $lines)
		{
			$linea = explode('|',$lines);
			if(is_numeric($linea[0]))
			{
				$db->setQuery("UPDATE `#__fanta_giocatore` 
								SET `squadra` = '". str_replace('"', '',$linea[3]) ."',
									`valore_att` = '$linea[4]'
								WHERE `#__fanta_giocatore`.`id` = $linea[0] LIMIT 1 ;");
				$db->query();
				$conta++;
				if($db->getAffectedRows()==0)
				{
					$data       =   new stdClass();
					$data->id= str_replace("\r\n",'', $linea[0]);
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
		
		/*
		foreach($matches[1] as $i => $riga)
		{
			
			preg_match_all("/<td[^>]*>(.*?)<\/td>/ms", $riga, $match);
			echo "UPDATE `#__fanta_giocatore` 
								SET `squadra` = '". str_replace('"', '',$match[1][3]) ."',
									`valore_att` = '".strip_tags($match[1][4])."' 
								WHERE `#__fanta_giocatore`.`id` = ".$match[1][0]." LIMIT 1 ;";
			exit;
			if(is_numeric($match[1][0]))
			{
				$db->setQuery("UPDATE `#__fanta_giocatore` 
								SET `squadra` = '". str_replace('"', '',$match[1][3]) ."',
									`valore_att` = '".strip_tags($match[1][4])."' 
								WHERE `#__fanta_giocatore`.`id` = ".$match[1][0]." LIMIT 1 ;");
				$conta++;
				$db->query();
				if($db->getAffectedRows()==0)
				{
					$data       		= new stdClass();
					$data->id			= strip_tags($match[1][0]);
					$data->pos			= strip_tags($match[1][1]);
					$data->nome			= strip_tags($match[1][2]);
					$data->squadra		= strip_tags($match[1][3]);
					$data->valore_att	= strip_tags($match[1][4]);
					$data->valore_ini	= strip_tags($match[1][5]);
					$db->insertObject('#__fanta_giocatore', $data, id);
				}
			}
		}*/
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
	
	function setDiretto($salva,$lega,$giornata)
	{
		$db     =& JFactory::getDBO();
		//print_r($salva);exit;
		foreach($salva as $squadra =>$value)
		{	
			$db->setQuery(
				"UPDATE `#__fanta_voti_squadra`
				 SET puntidiretti = ".$value->puntidiretti.",
					goal = ".$value->goal." WHERE squadra_id  = $squadra
				 AND giornata = $giornata
			");

			if (!$db->query()) {
					$this->setError($db->getErrorMsg());
					return false;
			}
		}
		
	}
			
	function setSquadra($salva,$lega,$giornata)
	{
		
		$db     =& JFactory::getDBO();
		
		//CALCOLA POSIZIONI PUNTI
		$db->setQuery("SELECT SUM(punti) as punti, squadra_id
						FROM `#__fanta_voti_squadra`
						LEFT JOIN #__fanta_squadra ON (`#__fanta_voti_squadra`.squadra_id = #__fanta_squadra.id)
						WHERE `giornata`< $giornata
						AND lega = $lega
						GROUP BY `squadra_id`
			");
		$punti = $db->loadObjectList();

		if (!$db->query()) {
				$this->setError($db->getErrorMsg());
				echo($db->getErrorMsg());
				exit;
		}

		foreach ($punti as $value)
			$value->punti +=$salva[$value->squadra_id]->punti;
		rsort($punti);
		foreach ($punti as $id => $value) 
			$salva[$value->squadra_id]->posizione = $id+1;

		//CALCOLA POSIZIONI PUNTIDIRETTI
		$db->setQuery("SELECT SUM(puntidiretti) as puntidiretti, squadra_id
						FROM `#__fanta_voti_squadra`
						LEFT JOIN #__fanta_squadra ON (`#__fanta_voti_squadra`.squadra_id = #__fanta_squadra.id)
						WHERE `giornata`< $giornata
						AND lega = $lega
						GROUP BY `squadra_id`
			");
		$punti = $db->loadObjectList();

		if (!$db->query()) {
				$this->setError($db->getErrorMsg());
				echo($db->getErrorMsg());
				exit;
		}
		
		foreach ($punti as $value)
			$value->puntidiretti +=$salva[$value->squadra_id]->puntidiretti;
		rsort($punti);
		foreach ($punti as $id => $value) 
			$salva[$value->squadra_id]->posizionediretti = $id+1;
		
		//print_r($salva);exit;
		//ESEGUO LA QUERY PER OGNI GIOCATORE				
		foreach ($salva as $squadra_id => $valore)
		{
			$db->setQuery(
				"UPDATE `#__fanta_voti_squadra`
				 SET punti = '".$valore->punti."',
					 puntidiretti = '".$valore->puntidiretti."',
					 posizione =    '".$valore->posizione."',
					 posizionediretti = '".$valore->posizionediretti."',
					 goal = '".$valore->goal."',
					 goalsubiti = '".$valore->goalsubiti."',
					 v = '".$valore->v."', n = '".$valore->n."', p = '".$valore->p."' 
				 WHERE squadra_id  = $squadra_id
				 AND giornata = $giornata
			");
			//print_r($db);exit;
			if (!$db->query()) {
					$this->setError($db->getErrorMsg());
					return false;
			}
		}
		
		return true;
	}
		
	function setFirst($lega)
	{
		$db     =& JFactory::getDBO();
		$last	=$this->getLast($lega);
		$next 	=$last + $lega->coppa_range;
		
		if($lega->coppa_range == 1)
			$condizione="giornata >= $lega->coppa_at";
		else
		{	
			$temp="$lega->coppa_at";
			for($i=$lega->coppa_at+$lega->coppa_range;$i<=$last;$i+=$lega->coppa_range)
				$temp.=",$i";
			$condizione=	"giornata IN ($temp)";
		}
		$limit 	= ($lega->coppa_gironi*$lega->coppa_qualifica) / 2;
		
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('idgruppo,idsquadra, SUM(#__fanta_voti_squadra.puntidiretti) as puntidiretti, SUM(#__fanta_voti_squadra.goal) as goals, SUM(#__fanta_voti_squadra.goalsubiti) as goalsubiti,COUNT(#__fanta_voti_squadra.punti) as giocate, SUM(#__fanta_voti_squadra.v) as v, SUM(#__fanta_voti_squadra.n) as n, SUM(#__fanta_voti_squadra.p) as p');
		// From the hello table
		$query->from('#__fanta_group');
		$query->leftJoin('#__fanta_voti_squadra ON #__fanta_group.idsquadra = #__fanta_voti_squadra.squadra_id');
		$query->group ('#__fanta_group.idsquadra');
		$query->where($condizione);
		$query->order ('idgruppo ASC, puntidiretti DESC, punti DESC');
		$db->setQuery( $query );
		$gironi=$db->loadObjectList();
		
		$sep = count($gironi) / 2 - 1;

		for($i=0;$i<$limit;$i++){
			$scontri[$i]->casa = $gironi[$i]->idsquadra;
			$scontri[$i]->trasferta = $gironi[$sep+$limit-$i]->idsquadra;
		}
//		for($gironi as $i => $girone)
//		{
//			if($i<$limit)
//				$scontri[($i%$limit)]->casa = $girone->idsquadra;
//			else
//				$scontri[($i%$limit)]->trasferta = $girone->idsquadra;
//		}

		foreach($scontri as $i => $scontro)
		{
			$scontro->lega = $lega;
			$scontro->giornata = $next;
			$scontro->idgruppo = $i;
			$scontro->stato = 1;
			$ret[] = $db->insertObject('#__fanta_scontri', $scontro);
		}
		return $ret;
	}
	
	function setOnes($lega,$giornata,$scontri)
	{
		//(PUNTI - DIFFERENZA RETI - TOTALE PUNTI)
		$db     =& JFactory::getDBO();
		
		$next 	=$last + $lega->coppa_range;
	}
	
	function setBack($scontri, $lega)
	{
		$db     =& JFactory::getDBO();
		
		$db->setQuery("DELETE FROM #__fanta_scontri
						WHERE giornata = $next");
		$db->query();
		
		//inserisco le voci del calendatio
		foreach($scontri as $scontro)
		{
			$scontro->giornata 	+= $lega->coppa_range;
			$scontro->stato 	= 2;
			$temp = $scontro->casa;
			$scontro->casa = $scontro->trasferta;
			$scontro->trasferta = $temp;
			//echo " => ";print_r($scontro);echo "<br>";
			$ret[] = $db->insertObject('#__fanta_scontri', $scontro);
		}
		return $ret;
	}
	
	function isLast($giornata)
	{
		$db     =& JFactory::getDBO();
		$db->setQuery("SELECT COUNT(giornata)
						FROM  `#__fanta_scontri` 
						WHERE  `giornata` > $giornata");
        return ($db->loadResult() == 0);
	}
	
	function isCoppa($giornata,$lega)
	{
		return (($giornata - $lega->coppa_at) % $lega->coppa_range) == 0;
	}
	
	function getLast($lega)
	{
		return $lega->coppa_at + (($lega->partecipanti/$lega->coppa_gironi - 1) * ($lega->coppa_ar?2:1) - 1) * $lega->coppa_range; 
	}
	
	function getScontri($giornata)
	{
		$db     =& JFactory::getDBO();
		$db->setQuery("SELECT * 
						FROM  `#__fanta_scontri` 
						WHERE  `giornata` = $giornata");
		$scontri=$db->loadObjectList();
		return $scontri;

	}

	public function CalcolaGoal($punti,$lega)
	{
		//print_r($lega);exit;
		$gfrom=$lega->goal_at;  //60.5; // Primo goal a
		$geach=$lega->goal_range;  // Goal ogni tot punti
			
		$goal = ($punti<$gfrom)?0:floor(($punti - $gfrom + $geach)/$geach);
        return $goal;
	}
	
    public function Ufficiale($giornata)
	{
            $db     =& JFactory::getDBO();
            
            $query ="SELECT giocata FROM `#__fanta_calendario` WHERE giornata = $giornata";
            $db->setQuery( $query );
            $ufficiale = $db->loadResult();
            
            return $ufficiale;
	}

}
