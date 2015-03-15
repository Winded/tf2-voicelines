<?php

require_once "bootstrap.php";

use Goutte\Client;

$client = new Client();

$manager = MyEntityManager::getInstance();
$vlRepo = $manager->getRepository("Voiceline");

$baseUrl = "https://wiki.teamfortress.com";
$classes = [
	"Scout" => [
		"https://wiki.teamfortress.com/wiki/Scout_responses",
		"https://wiki.teamfortress.com/wiki/Scout_voice_commands"
	],
	"Soldier" => [
		"https://wiki.teamfortress.com/wiki/Soldier_responses",
		"https://wiki.teamfortress.com/wiki/Soldier_voice_commands"
	],
	"Pyro" => [
		"https://wiki.teamfortress.com/wiki/Pyro_responses",
		"https://wiki.teamfortress.com/wiki/Pyro_voice_commands"
	],
	"Demoman" => [
		"https://wiki.teamfortress.com/wiki/Demoman_responses",
		"https://wiki.teamfortress.com/wiki/Demoman_voice_commands"
	],
	"Heavy" => [
		"https://wiki.teamfortress.com/wiki/Heavy_responses",
		"https://wiki.teamfortress.com/wiki/Heavy_voice_commands"
	],
	"Engineer" => [
		"https://wiki.teamfortress.com/wiki/Engineer_responses",
		"https://wiki.teamfortress.com/wiki/Engineer_voice_commands"
	],
	"Medic" => [
		"https://wiki.teamfortress.com/wiki/Medic_responses",
		"https://wiki.teamfortress.com/wiki/Medic_voice_commands"
	],
	"Sniper" => [
		"https://wiki.teamfortress.com/wiki/Sniper_responses",
		"https://wiki.teamfortress.com/wiki/Sniper_voice_commands"
	],
	"Spy" => [
		"https://wiki.teamfortress.com/wiki/Spy_responses",
		"https://wiki.teamfortress.com/wiki/Spy_voice_commands"
	],
];

function processNode($node, $class) {

	global $vlRepo, $baseUrl, $manager;

	$id = $node->attr("title");
	$link = $baseUrl . $node->attr("href");
	$quote = $node->text();
	if(!$id || !$link || !$quote) {
		return;
	}

	$vl = $vlRepo->find($id);
	if(!$vl) {
		$vl = new Voiceline();
		$vl->setId($id);
	}
	$vl->setPerson($class);
	$vl->setQuote($quote);
	$vl->setLink($link);

	$manager->persist($vl);

}

$lineCount = 0;
foreach($classes as $class => $links) {
	foreach($links as $link) {

		$crawler = $client->request("GET", $link);

		$links = $crawler->filter("td > ul > li > a[class='internal']");
		$links2 = $crawler->filter("td > ul > li > ul > li > a[class='internal']");

		$links->each(function($node) use ($class) {
			global $lineCount;
			processNode($node, $class);
			$lineCount++;
		});
		$links2->each(function($node) use ($class) {
			global $lineCount;
			processNode($node, $class);
			$lineCount++;
		});

	}
}

$manager->flush();
echo $lineCount . " lines processed\n";