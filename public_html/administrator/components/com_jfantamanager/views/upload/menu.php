<? include ("config.php"); ?>

<html>
<!-- Creation date: 04/09/02 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="Unregistered user">
<meta name="generator" content="AceHTML 5 Pro">
<script language="JavaScript1.3">
var Dirs = new Array();
var num_dirs = 0;
var dir_cur;
var separator = "/";

function ChDir(dir){
	if (dir == ".."){
		if (top.menu.num_dirs > 0){
			top.menu.Dirs[top.menu.num_dirs-1] = "";
			top.menu.num_dirs--;
		} else {
			alert ("Non hai il permesso di salire oltre questa cartella.");
		}
	} else {
		top.menu.Dirs[num_dirs] = dir;
		top.menu.num_dirs++;
	}
	top.menu.dir_cur = "share";
	for (top.menu.i=0;top.menu.i<top.menu.num_dirs;top.menu.i++){
		top.menu.dir_cur += separator+Dirs[i];
	}
	top.menu.document.all.cur_dir.innerHTML = "<font size=\"2\">Directory corrente: /"+top.menu.dir_cur+"</font>";
	return top.menu.dir_cur;
}
</script>
</head>
<body>
<table border=1 cellpadding=2 cellspacing=0 align=center style="position:absolute;top:0;left:0" width=450>
	<tr>
		<td width=300>
			<div id="cur_dir"><font size="2">Directory corrente: /share</font></div>
		</td>
	</tr>
</table>
</body>
</html>