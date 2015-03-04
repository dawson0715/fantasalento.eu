<?defined('_JEXEC') or die('Restricted access');?>
<?

print_r($this->stampa);
if($this->msg == '')
{
    echo '<h2 class="item-page-title"><img align="left" src="'.$this->root.'components/com_jfantamanager/images/soccer_4_32.png">Consegna formazione</h2>
            <hr width="100" />';
    echo $this->loadTemplate('probabili');
    echo $this->loadTemplate('scegli');
}
else if($this->scaduto != '')// || $this->scaduto == 'ora')
{
    echo '<h2 class="item-page-title"><img align="left" src="'.$this->root.'components/com_jfantamanager/images/soccer_3_32.png">Formazioni consegnate</h2>
          <hr width="100" />';
    echo $this->loadTemplate('chiuso');
}
else
{
    echo '<h2 class="item-page-title"><img align="middle" src="'.$this->root.'components/com_jfantamanager/images/soccer_2_32.png">Formazioni</h2>
          <hr width="100" />';
    echo JText::_($this->msg);    
}



