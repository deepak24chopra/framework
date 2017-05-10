<?php

namespace App\Models;

use PDO;

/*
Post Model

*/

class Post extends \Core\Model {
	/*
	get all posts in an associate array
	*/
	 public static function getAll() {
	 	// $host='localhost';
	 	// $dbname = 'mvc';
	 	// $username = 'root';
	 	// $password='';

	 	try {
	 		//$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);

	 		$db = static::getDB();

	 		$stmt = $db->query('select id,title,content from posts order by created_at');

	 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 		return $results;
	 	} catch (PDOException $e) {
	 		echo $e->getMessage();
	 	}
	 }
}