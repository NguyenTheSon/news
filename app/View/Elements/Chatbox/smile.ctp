$stylevar[htmldoctype]
<html xmlns="http://www.w3.org/1999/xhtml" dir="$stylevar[textdirection]" lang="$stylevar[languagecode]">
<head>
$headinclude
<script language="javascript">
function addsmilie(code)
{
	opener.document.fcb_form.hmess.value = opener.document.fcb_form.hmess.value + code;
}
</script>

<title>Mặt cười</title>
</head>

<body>

<table width="100%" border="0" class="tborder" cellpadding="$stylevar[cellpadding]" cellspacing="$stylevar[cellspacing]">
$smilieicon
</table>

</body>
</html>