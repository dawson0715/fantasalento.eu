<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

/**
 * HelloWorld Model
 */
class jFantaManagerModelClassifica extends JModelList
{
	/**
	 * @var string msg
	 */
	protected $Classifca;


        protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('id,nome,created_by,logo,cambi,bilancio, SUM(#__fanta_voti_squadra.punti) as punti');
		// From the hello table
		$query->from('#__fanta_squadra');
                $query->group ('id');
                $query->leftJoin('#__fanta_voti_squadra ON #__fanta_squadra.id = #__fanta_voti_squadra.squadra_id');
                $query->where('lega = 1');
                $query->order ('punti DESC');
		return $query;
	}
        
        function getGocatori()
        {
            $db =& JFactory::getDBO();

            $query ="SELECT *
                    FROM  #__fanta_squadra
                    WHERE lega = 1
                    ORDER BY nome ASC";
            $db->setQuery( $query );
            $items = $db->loadObjectList();
            foreach ($items as $item) {
                $query ="SELECT *
                    FROM  #__fanta_voti_squadra
                    WHERE squadra_id = $item->id
                    ORDER BY giornata";
                $db->setQuery( $query );
                $giorni = $db->loadObjectList();
                $lista='';
                foreach ($giorni as $giorno) {
                    if($giorno->posizione>0)
                        $lista.="[$giorno->giornata, ".(9-$giorno->posizione)."],";
                }
                $item->lista=substr($lista, 0, -1);
            }
            
            foreach($items as $i=>$value)
                $series .= "{
                                name: '$value->nome',
                                data: [".(($value->lista=='')?"[1,1]":$value->lista)."]
                             },";
            $series=substr($series, 0, -1);

            $chart[] = $series;
            
            $query ="SELECT squadra_id, SUM(punti) as punti, nome FROM #__fanta_voti_squadra LEFT JOIN #__fanta_squadra ON(#__fanta_voti_squadra.squadra_id = #__fanta_squadra.id) WHERE LEGA = 1 GROUP BY id ORDER BY punti ASC";
            $db->setQuery( $query );
            $partecipa = $db->loadObjectList();
            foreach ($partecipa as $i => $giorno)
            {
                $posizioni.="{
                    name: '$giorno->nome',
                    data: [$giorno->punti]
                 },";
                    //$posizioni.="$giorno->punti,";
            }
            
            $chart[] = substr($posizioni, 0, -1);
            return $chart;
        }
        
        function getGraficoPartecipa()
        {
            $db =& JFactory::getDBO();
            
            $query ="SELECT squadra_id, SUM(punti) as punti, nome FROM #__fanta_voti_squadra LEFT JOIN #__fanta_squadra ON(#__fanta_voti_squadra.squadra_id = #__fanta_squadra.id) WHERE LEGA = 1 GROUP BY id ORDER BY punti ASC";
            $db->setQuery( $query );
            $partecipa = $db->loadObjectList();
            foreach ($partecipa as $i => $giorno)
            {
                $posizioni.="{
                    name: '$giorno->nome',
                    data: [$giorno->punti]
                 },";
                    //$posizioni.="$giorno->punti,";
            }
            
            return substr($posizioni, 0, -1);
        }
}