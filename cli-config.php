<?php

if(php_sapi_name() != "cli") {
	die();
}

require_once "bootstrap.php";

$entityManager = MyEntityManager::getInstance();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);