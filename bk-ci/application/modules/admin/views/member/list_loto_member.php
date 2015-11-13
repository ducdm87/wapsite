<script type="text/javascript" src="<?php echo base_url().'public/calendar/calendar_us.js';?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'public/calendar/calendar.css';?>" />
<script src="<?php echo js_link('jquery.iframer.js', 'admin'); ?>"></script>

<div id="list_content">
	<?php $this->load->view('member/list_loto_member_ajax'); ?>
</div>