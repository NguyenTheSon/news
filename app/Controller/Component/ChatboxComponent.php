<?php
define ("CHATBOX_KEY","ngochip");
class ChatboxComponent extends Component {

    public function init($authUser) {

        $colorlist = array("Gold","Khaki","Orange","LightPink","Salmon","Tomato","Red","Brown","Maroon","DarkGreen","DarkCyan","LightSeaGreen"
                ,"LawnGreen","MediumSeaGreen","BlueViolet","Cyan","Blue","DodgerBlue","LightSkyBlue","White","DimGray","DarkGray","Black");
        $fcb_colorlist = "";
        foreach ($colorlist AS $ccolor)
        {
            $fcb_colorlist .= "<option style='background: $ccolor;' value='$ccolor'>$ccolor</option>";
        }
        $chatbox['color_list'] = $fcb_colorlist;
        $timenow=time();
        if($authUser) {
                $chatbox['username'] = rawurlencode($authUser['name']);
                $chatbox['key'] = md5(CHATBOX_KEY.$chatbox['username'].$authUser['role']);
                $chatbox['userid'] = $authUser['id'];
                $chatbox['groupid'] = $authUser['role'];
        }
        else{
                $chatbox['username'] = "";
                $chatbox['key'] = "";
                $chatbox['userid'] = "";
                $chatbox['groupid'] = "";
        }
        
    
        $chatbox['linkcookie']="?key=".$chatbox['key']."&userid=".$chatbox['userid']."&groupid=".$chatbox['groupid']."&username=".$chatbox['username'];
        return $chatbox;
    }

}