<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('layout/header');
$this->load->view('layout/sidebar');
?>
<div class="mainright">
<?php $this->load->view($tpl_file);?>
</div>
<?php $this->load->view('layout/footer');?>
