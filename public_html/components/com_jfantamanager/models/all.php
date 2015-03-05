<?php defined( '_JEXEC' ) or die( 'Restricted access' );// No direct access

class jFantaManagerModelAll extends JModelItem
{
	/**
	 * @var string msg
	 */
	protected $squadre;
        protected $giocatori;
        
        function getSquadre()
        {
            $db =& JFactory::getDBO();
            $lega=JRequest::getVar('lega', 1);
            $giornata=JRequest::getVar('giornata', 1);
            
            if($lega==0)
                $lega=1;
            if($giornata==0)
                $giornata=$this->getGiornata ();
            
            $query ="SELECT id,nome,data,ora FROM  #__fanta_squadra 
                    LEFT JOIN `#__fanta_voti_squadra`
                        ON (#__fanta_voti_squadra.squadra_id = #__fanta_squadra.id)
                    WHERE `lega` = $lega 
                        AND giornata = $giornata";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        
        function getGiocatori($id,$giornata)
        {
                
            $db =& JFactory::getDBO();
            
            $query ="SELECT pos,nome FROM `#__fanta_impiega` 
                    LEFT JOIN #__fanta_giocatore
                        ON(#__fanta_impiega.giocatore_id = #__fanta_giocatore.id)
                    WHERE #__fanta_impiega.squadra_id = $id
                    AND #__fanta_impiega.giornata = $giornata
                    ORDER BY riserva ASC, pos DESC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
//            if (count($datisquadra)==0 && $giornata>1)
//                $this->getGiocatori ($id, 1);
            return $datisquadra;
        }
        
        function getGiocatoriMobile($id,$giornata,$sostituzioni,$modificatore)
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
            $punteggio->goal = ($punteggio->punti<60)?0:floor(($punteggio->punti - 55.5)/5);
            return $punteggio;
        }
        
        public function calcolaModificatore($giocatori)
        {
//            rsort($giocatore['D']);
//            $media=($giocatore['P'][0]+$giocatore['D'][0]+$giocatore['D'][1]+$giocatore['D'][2])/4;
//            if($media <= 6)
//                $bonus=0;
//            else if($media <= 6.5)
//                $bonus=1;
//            else if($media <= 7)
//                $bonus=3;
            return 0;
        }
        
        public static function getGiornata()
	{
            $db = JFactory::getDBO();
            $data_fine = date('Y-m-d', mktime(0,0,0,date('m'),date('d')-2,date('Y')));
            
            //$query ="SELECT MIN(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` >= '$data_fine'";
            $query ="SELECT MAX(`giornata`) as giornata FROM `#__fanta_impiega`";
            $db->setQuery( $query );
            $giornata = $db->loadResult();
            
            return $giornata;
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