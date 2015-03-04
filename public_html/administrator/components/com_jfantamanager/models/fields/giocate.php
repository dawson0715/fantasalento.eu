<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldGiocate extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Giocate';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
//                $id = 1;
//                $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));
//		$db = JFactory::getDBO();
//
//                $query = $db->getQuery(true);
//		$query->select('DISTINCT giornata');
//		$query->from('#__fanta_voti');
//                $query->where("giocatore_id = 1");
//                $query->order('giornata');
//		$db->setQuery((string)$query);
//		$giornata = $db->loadObjectList();
                
//                foreach ($giornata as $value)
                for($i=0;$i<38;$i++)
                        $options[] = JHtml::_('select.option', $i, $i);
		
		return $options;
	}
}
