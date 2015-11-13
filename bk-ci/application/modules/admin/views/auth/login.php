<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>admin-Login</title>
<link type="text/css" rel="stylesheet" href="<?php echo css_link('admin.css','admin')?>" />
</head>

<body>
<div class="header">
	<div id="logo"><a href="javascript:;"></a></div>
</div>

<div class="mainlogin">
	<div class="bgform">
    	<div class="bgform_in">
        	<h1 class="png">Login form</h1>
        	<?php if($this->message->has('error')):?>
            <div class="error" style="width:96%; margin-left:5px; display:inline;"><h2><?php echo $this->message->display();?></h2></div>
            <?php endif;?>
            <div class="bglogin">
            <?php echo form_open(admin_url('login'));?>
            <?php 
            $submit = array(
            	'name'	=>	'submit',
            	'class'	=>	'btnlogin png'
            );
            ?>
            	<ul>
                	<li><?php echo form_input('username', set_value('username'), 'class="text"');?></li>
                    <li><?php echo form_password('password', '', 'class="text"');?></li>
                    <li>
                    	<span class="left" style="padding-top:5px;"><input type="checkbox" name="re_pass" value="1" style="border:0; padding:0; margin:0;" />Remember me</span>
                        <span class="right"><?php echo form_submit($submit);?></span>
                    </li>
                    <li class="end">
                    	<span class="left"><a href="<?php echo base_url();?>">Home</a></span>
                    </li>
                </ul>
            <?php  echo form_close();?>
            </div>
        </div>
    </div>
</div>



</body>
</html>