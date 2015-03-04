<table>
    <tr><th colspan='2'>PORTIERI</th></tr>
<?
for ($i=0;$i<3;$i++)
{
  echo "<tr><td>
            <select name='scelto[]'>".
                JHtml::_('select.options', $this->posizione['P'], 'value', 'text').
            "</select>
            </td><td>
             <input type='text' value='' name='rosa[]' />
        </td></tr>";
}

echo "<tr><th colspan='2'>DIFENSORI</th></tr>";
for ($i=3;$i<11;$i++)
{
  echo "<tr><td><select name='scelto[]'>".
                JHtml::_('select.options', $this->posizione['D'], 'value', 'text').
            "</select>
            </td><td>
             <input type='text' value='' name='rosa[]' />
        </td></tr>";
}
echo "<tr><th colspan='2'>CENTROCAMPISTI</th></tr>";
for ($i=11;$i<19;$i++)
{
  echo "<tr><td><select name='scelto[]'>".
                JHtml::_('select.options', $this->posizione['C'], 'value', 'text').
            "</select>
            </td><td>
             <input type='text' value='' name='rosa[]' />
        </td></tr>";
}
echo "<tr><th colspan='2'>ATTACCANTI</th></tr>";
for ($i=19;$i<25;$i++)
{
  echo "<tr><td><select name='scelto[]'>".
                JHtml::_('select.options', $this->posizione['A'], 'value', 'text').
            "</select>
            </td><td>
             <input type='text' value='' name='rosa[]' />
        </td></tr>";
}
?>
</table>