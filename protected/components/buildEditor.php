<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class buildEditor {

    function buildEditor($type = 'tinymce') {
        if ($type == 'tinymce')
            echo '<script type="text/javascript" src="/editors/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
        ?>
        <script type="text/javascript">
            tinyMCE.init({
                // General options
//                forced_root_block:"",
                editor_selector: "mce_editable",
                language: "en",
                mode: "specific_textareas",
                skin: "default",
                theme: "advanced",
//                plugins: "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
                // Theme options
                theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
                //        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                theme_advanced_buttons2: "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,preview",
                //        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                theme_advanced_buttons3: "hr,removeformat,visualaid,|,sub,sup,|,attribs,pagebreak",
                //        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "left",
                theme_advanced_statusbar_location: "bottom",
                theme_advanced_resizing: true
            });
        </script>
        <?php
    }

    function show($name, $id, $value = "", $cols = "75", $rows = "20") {
        ?>        
        <textarea id="<?php echo $id; ?>" name="<?php echo $name; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>" style="width:100%; height:550px;" class="mce_editable"><?php echo $value; ?></textarea>
        <?php
    }

}
