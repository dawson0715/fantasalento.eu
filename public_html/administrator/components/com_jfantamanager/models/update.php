<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * HelloWorld Model
 */
class jFantaManagerModelUpdate extends JModelAdmin
{

    public static function getGiornata()
    {
        $db     =& JFactory::getDBO();
        $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));

        $query ="SELECT MIN(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` >= '$data_fine'";
        $db->setQuery( $query );
        $giornata = $db->loadResult();

        return $giornata;
    }

}
