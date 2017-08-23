<?php

/**
 * Class Template
 */
abstract class Template
{

	/**
	 * @var
	 */
	protected $subject;

	/**
	 * @var
	 */
	protected $body;

	/**
	 * @return mixed
	 */
	public function getSubject () {
		return $this->subject;
	}

	/**
	 * @param $customerName
	 * @return string
	 */
	public function renderTemplate ( $customerName ) {
		return sprintf($this->body, $customerName);
	}
}