<?php

/** @Entity @Table(name="voicelines") **/
class Voiceline
{

	/** @Id @Column(type="string") **/
	protected $id;

	/** @Column(type="string") **/
	protected $person;

	/** @Column(type="string") **/
	protected $quote;

	/** @Column(type="string") **/
	protected $link;

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}

	public function getPerson() {
		return $this->person;
	}
	public function setPerson($person) {
		$this->person = $person;
	}

	public function getQuote() {
		return $this->quote;
	}
	public function setQuote($quote) {
		$this->quote = $quote;
	}

	public function getLink() {
		return $this->link;
	}
	public function setLink($link) {
		$this->link = $link;
	}

	public function toArray() {
		return [
			"id" => $this->getId(),
			"person" => $this->getPerson(),
			"quote" => $this->getQuote(),
			"link" => $this->getLink()
		];
	}

}