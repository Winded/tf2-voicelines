<?php

require_once "bootstrap.php";
use Doctrine\ORM\Query\QueryException;

header("Content-type: application/json");

$manager = MyEntityManager::getInstance();
$vlRepo = $manager->getRepository("Voiceline");

$qb = $vlRepo->createQueryBuilder("vl");
$qb->select("vl");
foreach($_GET as $key => $value) {
	$qb->where($qb->expr()->like("vl.$key", ":$key"));
}

$query = $qb->getQuery();
foreach($_GET as $key => $value) {
	$query->setParameter($key, "%$value%");
}

try {
	$voicelines = $query->getResult();	
}
catch(QueryException $ex) {
	http_response_code(400);
	echo json_encode(["message" => "Invalid query"]);
	return;
}

$voicelines = array_map(function($vl) {
	return $vl->toArray();
}, $voicelines);

echo json_encode($voicelines);