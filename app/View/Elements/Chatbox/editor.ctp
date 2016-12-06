<tr><td class="alt2">
<div id="fcb_smilieboxmain" style="display: none;">
	<div align="center">
		<input type="button" class="button" value="xem thêm" onclick="fcb_showsmilies();">
		<input type="button" class="button" value="tất cả" onclick="smiliepopup();">
		<input type="button" class="button" value="Đóng" onclick="fcb_hideshowsmiliebox();">
	</div>
	<div id="fcb_smiliebox" align="center" style="margin-top: 3px; margin-bottom: 3px;"></div>
</div>
<form name="fcb_form" method="post" action="javascript:fcb_postshout();">
<div align="center">
<table class="col-xs-12"><tr>
<td>
<input id="hmess" onkeyup="checkhip(this);" type="text" class="bginput" name="hmess" style="width:100%;" <?php if(!isset($authUser['id'])){ echo "disabled";}?>>
</td>
<td>
</td>
</tr></table>
</div>
<div style="margin-top: 2px;" align="center">
<input type="submit" class="button" value="Chat" <?php if(!isset($authUser['id'])){ echo "disabled";}?>>
<input style="font-weight: bold;" type="button" name="hbold" value="B" class="button" onclick="fcb_upstyle('b');" <?php if(!isset($authUser['id'])){ echo "disabled";}?>>
<input style="font-style: italic;" type="button" name="hitalic" value="I" class="button" onclick="fcb_upstyle('i');" <?php if(!isset($authUser['id'])){ echo "disabled";}?>>
<input style="text-decoration: underline;" type="button" name="hunderline" value="U" class="button" onclick="fcb_upstyle('u');" <?php if(!isset($authUser['id'])){ echo "disabled";}?>>
<input type="hidden" name="hfont" value="" />
<input type="button" value="Refesh" class="button" onclick="fcb_refresh();">
<input type="button" value="Lưu trữ" class="button" onclick="archivepage();">
<select onchange="fcb_upstyle('color');" name="hcolor"  <?php if(!isset($authUser['id'])){ echo "disabled";}?>>
<option value="">Chọn màu</option>
<?php echo $chatbox['color_list'];?>
</select>

</div>
</form>
</td></tr>