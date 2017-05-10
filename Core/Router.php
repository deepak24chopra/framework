<?php

namespace Core;


/**
* router class
*/
class Router {

	/*
	associate array of routes (the routing table)
	@var array
	*/

	protected $routes = [];

	/*
	parameters from the matched route
	@var array
	return array
	*/

	protected $params = [];

	/*
	add a route to the routing table

	@param string $route the Route URL
	@param array $params Parameters (controller, action etc)

	@return void
	*/

	public function add($route, $params = []) {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }


	/*
	get all the routes from the routing table
	return an array
	*/

	public function getRoutes() {
		return $this->routes;
	}

	/*
	match the route to the routes in the routing table, setting the params
	property if the route is found

	@param string $url the route url

	return boolean true if route is matched otherwise false
	*/

	public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
	/*
	get the currntly matched url and parameters
	return array
	*/

	public function getParams() {
		return $this->params;
	}

	public function dispatch($url) {

		$url = $this->removeQueryStringVariables($url);

		if ($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
            //$controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

			if (class_exists($controller)) {
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);

				if (is_callable([$controller_object, $action])) {
					$controller_object->$action();

				} else {
					throw new \Exception("Method $action (in controller $controller) cannot be found");
				}
			} else {
				throw new \Exception("Controller class $controller cannot be found");
			}

		} else {
			throw new \Exception("No route matched.", 404);
		}
	}

	/*
	convert the string with hyphens to StudlyCaps
	eg post-authors => PostAuthors
	parameter string the string to convert
	return string
	*/

	protected function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

	/*
	convert the string with hyphens to camelCase
	eg add-new => addNew
	parameter string the string to convert
	return string
	*/

	protected function convertToCamelCase($string) {
		return lcfirst($this->convertToStudlyCaps($string));
	}
    
    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    
    protected function removeQueryStringVariables($url) {
        if($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
            	$url = $parts[0];
            } else {
            	$url = "";
            }
        }

        return $url;
    }

    /*
    get the namespace of the controller class. the namespace defined in the route parameters is added
    if present 
    returns string the requested url
	*/
    protected function getNamespace() {
    	$namespace = "App\Controllers\\";

    	if (array_key_exists('namespace', $this->params)) {
    		$namespace .= $this->params['namespace'] . '\\';
    	}

    	return $namespace;
    }
    
    
    
}