<?php

namespace Core;

/**
* Error and Exception handler
*/

class Error {
	/*
	Error Handler
	Convert all errors to exceptions by throwing an errorexception

	@param int $level Error level
	@param string $message Error Message
	@param string $file Filename the error was raised in
	@param int $line The line number the was raised in

	return void
	*/
	public static function errorHandler($level, $message, $file, $line) {
		if (error_reporting() !== 0) {
			throw new \ErrorException($message, 0, $level, $file, $line);
		}
	}

	/*
	Exception Handler
	@param Exception $exception the Exception
	return void
	*/
	public static function exceptionHandler($exception) {

		//code is 404(not found) or 500(sever error or internal error)
		$code = $exception->getCode();
		if ($code != 404) {
			$code = 500;
		}

		http_response_code($code);

		if(\App\Config::SHOW_ERRORS) {
			echo '<h1>Fatal Error</h1>';
			echo "<p>Uncaught Exception: '" . get_class($exception) . "'</p>";
			echo "<p>Message: '" . $exception->getMessage() . "'</p>";
			echo "<p>Stack Trace: <pre>" . $exception->getTraceAsString() . "</pre></p>";
			echo "<p>Thrown in: '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
		} else {
			$log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
			ini_set('error_log', $log);
			$message = "Uncaught Exception: '" . get_class($exception) . "'";
			$message .= " with message '" . $exception->getMessage() . "'";
			$message .= "\nStack Trace '" . $exception->getTraceAsString() . "'";
			$message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

			error_log($message);
			//echo "<h1>An Error Occured</h1>";
			if ($code == 404) {
				echo "<h1>Page not found</h1>";
			} else {
				echo "<h1>An error occured</h1>";
			}
			//view::render("$code.html");
		}
	}
}