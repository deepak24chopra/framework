<?php
namespace Core;

use PDO;
use App\Config;

/*
Base model
*/

abstract class Model {
	/*
	get the pdo database connection

	return @mixed
	*/
	protected static function getDB() {
		static $db=null;

		if ($db===null) {
			try {
				//$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);
				$dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
				$db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

				//throw and exception when an error occurs
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				return $db;
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
}