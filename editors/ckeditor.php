<?php
	require_once('ckeditor/ckeditor.php');
	 $config = array();
	 $config['toolbar'] = array(
	     array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
	     array( 'Image', 'Link', 'Unlink', 'Anchor' )
	 );
	  $events['instanceReady'] = 'function (ev) {
	     	
	 	}';
	$CKEditor = new CKEditor('http://server.com/minisite/editor/ckeditor/'); 
	$CKEditor->Height = '900px';	
?> 
<style type="text/css">
		.cke_skin_kama .cke_wrapper {   
			height:480px;  
			width:700px;
		}
		#cke_contents_content
		{
			height:420px !important;
		}
		#cke_content{
			width:710px;
		}
</style>    
<h1>	Nhập Bài viết</h1>
<div class="colleft">
	<div style="margin: 0 0 0 10px; height: 500px;">
		<?php
			$CKEditor->editor("content", 'content here', $config, $events);
		?>
		</div>
</div>
<style type="text/css">
table{
    background-color:#E7E7E7;
    border-spacing:1px;
    color:#666666;
    width:100%;
}
table thead th {
    background:none repeat scroll 0 0 #F0F0F0;
    border-bottom:1px solid #999999;
    border-left:1px solid #FFFFFF;
    color:#666666;
    text-align:center;
    padding:4px;
}
table tbody tr {
    background-color:#FFFFFF;
    text-align:left;
}
table tbody tr td {
    background:none repeat scroll 0 0 #FFFFFF;
    border:1px solid #FFFFFF;
    height:25px;
    padding:4px;
}

.colleft
{
	border-right:1px solid #EEEEEE;
    float:left;
    width:48%;
}
.colright {
    float:right;
    width:50%;
}

</style>


<script type="text/javascript">
function removecontent(id)
{
	var eid	=	'myform'+id;
	var e	=	document.getElementById(eid);
	if (confirm('Are you sure you want to remove Item ?'))
	{ 
		e.submit();
	}
	//e.submit();	
}

</script>


