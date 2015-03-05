<?php

namespace Message\Mothership\DiscountReward\Mailer;

use Message\Cog\Mail\Message;
use Message\Cog\Mail\Mailer;
use Message\Cog\Localisation\Translator;
use Message\Mothership\ReferAFriend\Referral\Exception\EmailException;

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

	protected function _send()
	{
		$failed = [];
		$this->_mailer->send($this->_message, $failed);

		if (count($failed) > 0) {
			throw new \RuntimeException('Failed to send ' . count($failed) . ' emails');
		}
	}
}