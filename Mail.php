<?php

/**
 * Class Mail
 */
class Mail
{

	/**
	 * @var template
	 */
	protected $template;

	/**
	 * @var
	 */
	protected $body;

	/**
	 * @var
	 */
	protected $subject;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var string
	 */
	protected $from = "info@cikumus.com";

	/**
	 * @param Template $template
	 */
	public function setTemplate ( Template $template ) {
		$this->template = $template;
	}

	/**
	 * Mail constructor.
	 * @param Customer $customer
	 */
	public function __construct ( Customer $customer ) {
		$this->customer = $customer;
	}

	/**
	 * @param $subject
	 */
	public function setSubject ( $subject ) {
		$this->subject = $subject;
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function send () {
		if ( !isset( $this->customer->email ) ) {
			throw new \Exception('Customer doesn\'t have an email address.');
		}
		if ( !isset( $this->template ) ) {
			throw new \Exception('Customer doesn\'t have an template.');
		}
		return mail($this->customer->email, $this->subject, $this->template->renderTemplate($this->customer->email));
	}
}
