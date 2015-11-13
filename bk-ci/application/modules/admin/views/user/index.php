<h1><?php echo lang($MODULE.'_MANAGER');?></h1>
<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>

<div id="user_list">
<?php $this->load->view('user/list'); ?>
</div>