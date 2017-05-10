<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Post;

/**
* posts controller
*/
class Posts extends \Core\Controller {

	//show the index page
	//returns void
	public function indexAction() {
		$posts = \App\Models\Post::getAll();
		View::render('Posts/index.php', [
			'posts' => $posts
			]);
	}


	//shows the add new page
	//returns void
	public function addNewAction() {
		echo "Hello from the addNew action of the posts controller";
	}
    
    public function editAction() {
        echo "Hello from the edit function Posts Controller";
        echo "<p>Route Parameters<pre>";
        echo htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }

}