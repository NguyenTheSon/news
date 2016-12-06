/* 
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved. 
For licensing, see LICENSE.html or http://ckeditor.com/license 
*/ 

CKEDITOR.editorConfig = function( config ) 
{ 
        // Define changes to default configuration here. For example: 
    config.language = 'vi'; 
     
        // config.uiColor = '#AADC6E'; 
         
        config.toolbar_Full = [ 
            ['Source','-','Save','NewPage','Preview','-','Templates'], 
            ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'], 
            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'], 
            '/', 
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'], 
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'], 
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], 
            ['BidiLtr', 'BidiRtl' ], 
            ['Link','Unlink','Anchor'], 
            ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'], 
            '/', 
            ['Styles','Format','Font','FontSize'], 
            ['TextColor','BGColor'], 
            ['Maximize', 'ShowBlocks','-','About'] 
            ]; 
         
        config.entities = false; 
        //config.entities_latin = false; 
        config.enterMode = CKEDITOR.ENTER_BR;
		config.skin= 'office2013';
     //   config.filebrowserBrowseUrl = './includes/ckfinder/ckeditor.html'; 
	 config.extraPlugins = 'youtube';
	 config.youtube_width = '640';
	config.youtube_height = '480';
	config.youtube_related = true;
	config.youtube_older = false;
	config.youtube_privacy = false;

};  