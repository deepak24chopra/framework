<?php
/*
User admin controller
*/

namespace App\Controllers\Admin;

class Users extends \Core\Controller{
	/*
	before filter
	*/

	protected function before() {
		// before filter
	}

	public function indexAction() {
		echo "User admin index";
	}

}