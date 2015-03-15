<?php

require_once "bootstrap.php";
use Doctrine\ORM\Query\QueryException;

header("Content-type: application/json");

$manager = MyEntityManager::getInstance();
$vlRepo = $manager->getRepository("Voiceline");

$qb = $vlRepo->createQueryBuilder("vl");
$qb->select("vl");
if(count($_GET) > 0) {
	$likes = [];
	foreach($_GET as $key => $value) {
		array_push($likes, $qb->expr()->like("vl.$key", ":$key"));
	}
	$andX = $qb->expr()->andX();
	$andX->addMultiple($likes);
	$qb->where($andX);
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