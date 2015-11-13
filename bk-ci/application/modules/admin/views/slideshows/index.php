<h1><?php echo lang('SLIDE_MANAGER');?></h1>
<script type="text/javascript" src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>
<div id="articles_list">
<?php $this->load->view('slideshows/list'); ?>
</div>