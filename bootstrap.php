<?php

require_once "vendor/autoload.php";

ini_set("display_errors", 1);

$dir = dirname(__FILE__) . "/entities";
foreach(scandir($dir) as $filename) {
	$path = $dir . "/" . $filename;
	if(is_file($path)) {
		require_once $path;
	}
}

require_once "entities/Voiceline.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class MyEntityManager
{

	public static $manager;

	public function getInstance() {
		if(!isset(self::$manager)) {
			self::createInstance();
		}
		return self::$manager;
	}

	public function createInstance() {

		$paths = ["/var/www/voicelines/entities"];
		$devMode = true;

		$dbParams = [
			"driver" => "pdo_mysql",
			"user" => "tf2voicelines",
			"password" => "tf2voicelines",
			"dbname" => "tf2voicelines"
		];

		$config = Setup::createAnnotationMetadataConfiguration($paths, $devMode);
		self::$manager = EntityManager::create($dbParams, $config);

	}

}