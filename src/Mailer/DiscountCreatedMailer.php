<?php

namespace Message\Mothership\DiscountReward\Mailer;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\Discount\Discount\Discount;

class DiscountCreatedMailer extends AbstractMailer
{
	public function inform(ReferralInterface $referral, Discount $discount)
	{
		$this->_message->setTo($referral->getReferrer()->email, $referral->getReferrer()->getName());
		$this->_message->setSubject($this->_translator->trans('ms.discount_reward.email.success.subject'));

		$this->_message->setView('Message:Mothership:DiscountReward::discount_reward:email:discount_create', [
			'toName'   => $referral->getReferrer()->getName(),
			'message'  => $this->_translator->trans('ms.discount_reward.email.success.message'),
			'discount' => $discount,
		]);

		$this->_send();
	}
}