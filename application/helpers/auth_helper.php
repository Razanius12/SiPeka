<?php
function check_access($allowed_roles)
{
	$CI =& get_instance();

	if (!$CI->session->userdata('role')) {
		redirect('C_Auth/Logout');
	}
	
	if (!in_array($CI->session->userdata('role'), $allowed_roles)) {
		redirect('C_Auth/unauthorized');
	}
}
