<?php

require_once "bootstrap.php";

$entityManager = MyEntityManager::getInstance();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);