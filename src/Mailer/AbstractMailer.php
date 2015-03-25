<?php

namespace Message\Mothership\DiscountReward\Mailer;

use Message\Cog\Mail\Message;
use Message\Cog\Mail\Mailer;
use Message\Cog\Localisation\Translator;

/**
 * Class AbstractMailer
 * @package Message\Mothership\DiscountReward\Mailer
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Abstract class for simplifying the process of sending an email to a user
 */
abstract class AbstractMailer
{
	/**
	 * @var Translator
	 */
	protected $_translator;

	/**
	 * @var Message
	 */
	protected $_message;

	/**
	 * @var Mailer
	 */
	protected $_mailer;

	public function __construct(Mailer $mailer, Message $message, Translator $translator)
	{
		$this->_mailer     = $mailer;
		$this->_message    = $message;
		$this->_translator = $translator;
	}

	/**
	 * Send the message.
	 *
	 * @throws \RuntimeException   Throws exception if the email could not be sent
	 */
	protected function _send()
	{
		$failed = [];
		$this->_mailer->send($this->_message, $failed);

		if (count($failed) > 0) {
			throw new \RuntimeException('Failed to send ' . count($failed) . ' emails');
		}
	}
}