
<div class="col-xs-11 col-md-5 chatbox close">
<h1>Tán gẫu</h1>
<div class="minium"><i class="fa fa-minus-square"></i></div>
	<table class="col-xs-12 tborder" cellpadding="0" cellspacing="0" border="0" align="center">
	<tbody id="collapseobj_changfcb" style="">
	<tr><td class="alt1">

	<iframe name="fcb_frame" src="/chatbox/index.php" frameborder="0" style="width: 100%; height: 250px;"></iframe>

	</td>
	</tr>

	<?php echo $this->element('Chatbox/editor'); ?>

	</tbody>
	</table>
</div>
<script language="JavaScript" type="text/javascript">
fcb_setCookie('fcb_userid', '1');
var textstyle = document.getElementById('hmess');

if (fcb_getCookie('fcb_b_userid1').length > 0)
{
	document.fcb_form.hbold.value = fcb_getCookie('fcb_b_userid1');
}

if (fcb_getCookie('fcb_i_userid1').length > 0)
{
	document.fcb_form.hitalic.value = fcb_getCookie('fcb_i_userid1');
}

if (fcb_getCookie('fcb_u_userid1').length > 0)
{
	document.fcb_form.hunderline.value = fcb_getCookie('fcb_u_userid1');
}

if (fcb_getCookie('fcb_font_userid1').length > 0)
{
	document.fcb_form.hfont.value = fcb_getCookie('fcb_font_userid1');
}

if (fcb_getCookie('fcb_color_userid1').length > 0)
{
	document.fcb_form.hcolor.value = fcb_getCookie('fcb_color_userid1');
}
fcb_upstyle_cookie();
function fcb_upstyle_cookie()
{
		if (document.fcb_form.hbold.value == 'B*')
		{
			textstyle.style.fontWeight = 'bold';
		}
		else
		{
			textstyle.style.fontWeight = 'normal';
		}

		if (document.fcb_form.hitalic.value == 'I*')
		{
			textstyle.style.fontStyle = 'italic';
		}
		else
		{
			textstyle.style.fontStyle = 'normal';
		}
		

		if (document.fcb_form.hunderline.value == 'U*')
		{
			textstyle.style.textDecoration = 'underline';
		}
		else
		{
			textstyle.style.textDecoration = 'none';
		}
		
	textstyle.style.fontFamily = document.fcb_form.hfont.value;
	textstyle.style.color = document.fcb_form.hcolor.value;
}


function fcb_upstyle(element)
{
	if (element == 'b')
	{
		if (document.fcb_form.hbold.value == 'B')
		{
			document.fcb_form.hbold.value = 'B*';
			textstyle.style.fontWeight = 'bold';
		}
		else
		{
			document.fcb_form.hbold.value = 'B';
			textstyle.style.fontWeight = 'normal';
		}
		
	}
	if (element == 'invi')
	{
		if (document.fcb_form.invi.value == '1')
		{
			document.fcb_form.invi.value = '0';
		}
		else
		{
			document.fcb_form.invi.value = '1';
		}
		
	}
	else if (element == 'i')
	{
		if (document.fcb_form.hitalic.value == 'I')
		{
			document.fcb_form.hitalic.value = 'I*';
			textstyle.style.fontStyle = 'italic';
		}
		else
		{
			document.fcb_form.hitalic.value = 'I';
			textstyle.style.fontStyle = 'normal';
		}
		
	}
	else if (element == 'u')
	{
		if (document.fcb_form.hunderline.value == 'U')
		{
			document.fcb_form.hunderline.value = 'U*';
			textstyle.style.textDecoration = 'underline';
		}
		else
		{
			document.fcb_form.hunderline.value = 'U';
			textstyle.style.textDecoration = 'none';
		}
		
	}
	else if (element == 'font')
	{
			textstyle.style.fontFamily = document.fcb_form.hfont.value;
	}
	else if (element == 'color')
	{
			textstyle.style.color = document.fcb_form.hcolor.value;
	}
	
	fcb_setCookie('fcb_b_userid1', document.fcb_form.hbold.value);
	fcb_setCookie('fcb_i_userid1', document.fcb_form.hitalic.value);
	fcb_setCookie('fcb_u_userid1', document.fcb_form.hunderline.value);
	fcb_setCookie('fcb_font_userid1', document.fcb_form.hfont.value);
	fcb_setCookie('fcb_color_userid1', document.fcb_form.hcolor.value);
}

function fcb_setCookie(c_name,value)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+365);
	document.cookie=c_name+ "=" +escape(value)+ ";expires="+exdate.toGMTString() + "path=/";
}
function fcb_getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=");
  if (c_start!=-1)
    { 
    c_start=c_start + c_name.length+1; 
    c_end=document.cookie.indexOf(";",c_start);
    if (c_end==-1) c_end=document.cookie.length;
    return unescape(document.cookie.substring(c_start,c_end));
    }
else { return ""; }
  }

}

var huid = '1';
var hgroupid = '1';
var huser = "<?php echo $chatbox['username'];?>";

function fcb_postshout()
{
	
	var chatboxkey = "<?php echo $chatbox['key'];?>";
		hmess = document.fcb_form.hmess.value;
		hcolor = document.fcb_form.hcolor.value;
		hfont = document.fcb_form.hfont.value;
		hbold = document.fcb_form.hbold.value;
		hitalic = document.fcb_form.hitalic.value;
		hunderline = document.fcb_form.hunderline.value;
		document.fcb_form.hmess.value = '';
		if (hmess == '')
		{
			alert('trống');
		}
		else
		{
		hmess = hmess.replace(/\/\//g,'/ /');
		hmess = hmess.replace(/\/suachu /g,'/suachu !');
			fcb_frame.location = '/chatbox/index.php?do=postshout&key=' + chatboxkey +  '&userid=' + huid + '&groupid=' + hgroupid + '&username=' + huser + '&message=' + encodeURIComponent(hmess) + '&color=' + hcolor + '&font=' + hfont + '&bold=' + hbold + '&italic=' + hitalic + '&underline=' + hunderline;
		}
		
}

function archivepage()
{
	window.open("/chatbox/archive.php", "fcbarchive", "location=no,scrollbars=yes,width=640,height=480");
}
function upanh()
{
	window.open("http://upanh.phongcachteen.biz", "uploadimage", "location=no,scrollbars=yes,width=740,height=400");
}
function notpmrieng()
{
	f_pmrieng.location = '/chatbox/pm.php?chung=1';
}

function addsmilie(code)
{
	document.fcb_form.hmess.value = document.fcb_form.hmess.value + code;
}
function smiliepopup()
{
	window.open("ajax.php?do=fcb_allsmilies", "fcballsmilies", "location=no,scrollbars=yes,width=500,height=500");
}

function fcb_showsmilies_action()
{
     if (fcb.handler.readyState == 4 && fcb.handler.status == 200)
		{
			document.getElementById('fcb_smiliebox').innerHTML = fcb.handler.responseText;
		}
}
function fcb_showsmilies()
{
	document.getElementById('fcb_smiliebox').innerHTML = 'vui lòng đợi';
	fcb = new vB_AJAX_Handler(true);
	fcb.onreadystatechange(fcb_showsmilies_action);
	fcb.send('ajax.php?do=fcb_randomsmilies');
}
function fcb_showsmiliebox()
{
	if (document.getElementById('fcb_smilieboxmain').style.display == 'none')
	{
		document.getElementById('fcb_smilieboxmain').style.display = 'inline';
		fcb_showsmilies();
	}
	else
	{
		document.getElementById('fcb_smilieboxmain').style.display = 'none';
	}
}


function fcb_hideshowsmiliebox()
{
	document.getElementById('fcb_smilieboxmain').style.display = 'none';
}
function showsmsbox()
{
		if (document.getElementById('smsbox').style.display == 'none')
	{
		document.getElementById('smsbox').style.display = 'inline';
		fcb_showsmilies();
	}
	else
	{
		document.getElementById('smsbox').style.display = 'none';
	}
}
function hidesmsbox()
{
	document.getElementById('smsbox').style.display = 'none';
}
function fcb_refresh()
{
	fcb_frame.location = '/chatbox/index.php';
}
 function checkhip(field) { 
	if(field.value.length <= 1){
                    field.value = field.value.replace(/0/g," 0"); 
					}   
    }
   $(".chatbox h1").click(function(){
   		if($(".chatbox").hasClass('close')){
   			$(".chatbox").removeClass('close',1000);
   		}
   		else{
   			$(".chatbox").addClass('close',1000);
   		}
   });
   $(".chatbox .minium").click(function(){
   		if($(".chatbox").hasClass('close')){
   			$(".chatbox").removeClass('close',1000);
   		}
   		else{
   			$(".chatbox").addClass('close',1000);
   		}
   });
</script>