<?php

namespace Message\Mothership\DiscountReward\Mailer;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\DiscountReward\Reward\Exception\DiscountBuildException;

class CreateFailedMailer extends AbstractMailer
{
	public function report(ReferralInterface $referral, DiscountBuildException $e)
	{
		$this->_message->setTo($referral->getReferrer()->getName(), $referral->getReferrer()->email);
		$this->_message->setSubject($this->_translator->trans('ms.discount_reward.email.failure.subject'));

		$this->_message->setView('Message:Mothership:DiscountReward::discount_reward:email:create_failed', [
			'toName'  => $referral->getReferrer()->getName(),
			'message'  => $this->_translator->trans('ms.discount_reward.email.failure.message'),
			'error'    => $e->getMessage(),
		]);

		$this->_send();
	}
}