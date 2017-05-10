<?php

namespace App\Controllers;

use \Core\View;
/*
Home Controller

*/

class Home extends \Core\Controller {
    /*
    shows the index page
    return void
    */
    public function indexAction() {
        //echo "Hello from the index action of home controller";
        View::render('Home/index.php',[
            'name' => 'Deepak',
            'colors' => ['red','green','blue']
            ]);
        // View::renderTemplate('Home/index.html', [
        //     'name' => 'Dave',
        //     'colors' => ['red','blue','green']
        //     ]);
    }

    protected function before() {
    	//echo "before";
    }

    protected function after() {
    	//echo "(after)";
    }
    
    
}