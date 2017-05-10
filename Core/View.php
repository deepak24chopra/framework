<?php

namespace Core;

class View {
	
	/*
	renders a view file
    params string $view the view file
    returns void
	*/
    
    public static function render($view, $args=[]) {
        extract($args, EXTR_SKIP);
        $file = "../App/Views/$view"; //relative to core directory
        
        if(is_readable($file)) {
            require $file;
        } else {
            //echo "$file not found";
            throw new Exception("$file not found");
            
        }
        
    }

    /*
    render a view template using twig
    @params string template The template file
    @param array args[] Associative array of data to display in the view
    return void
    */

    public static function renderTemplate($template, $args=[]) {
        static $twig=null;
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }
        echo $twig->loadTemplate($template,$args);
    }


}