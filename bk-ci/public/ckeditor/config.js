/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
var ADMIN_IMAGE_INPUT_TEXT = '0';
//var base_url = 'http://localhost/';
CKEDITOR.editorConfig = function( config )
{
    config.language = 'en';
    config.uiColor = '#dcdcdc';
    config.toolbar = 'MyToolbar';

    config.toolbar_MyToolbar =
        [
        ['Source','Maximize'],
        ['NewPage','Preview'],
        ['PasteText','PasteFromWord'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        ['Image','Flash','Table','HorizontalRule'],
        '/',
        ['Styles','Format'],
        ['Font','FontSize'],
        ['TextColor','BGColor'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],        
        ['Bold','Italic','Strike'],
        ['NumberedList','BulletedList'],
        ['Link','Unlink'],
        ['Maximize']
        ];

		config.filebrowserBrowseUrl = base_url + 'public/ckfinder/ckfinder.html';
		config.filebrowserImageBrowseUrl = base_url + 'public/ckfinder/ckfinder.html?type=Images';
		config.filebrowserUploadUrl = base_url + 'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		config.filebrowserImageUploadUrl = base_url + 'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

};
