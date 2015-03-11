<?php

namespace Message\Mothership\DiscountReward\Mailer;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\Discount\Discount\Discount;

/**
 * Class DiscountCreatedMailer
 * @package Message\Mothership\DiscountReward\Mailer
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Class for informing a referrer that the email address they referred has fulfilled what is needed to be eligible for
 * a discount reward to be granted
 */
class DiscountCreatedMailer extends AbstractMailer
{
	/**
	 * Inform the referrer that a discount code has been generated for them
	 *
	 * @param ReferralInterface $referral
	 * @param Discount $discount
	 */
	public function inform(ReferralInterface $referral, Discount $discount)
	{
		$this->_message->setTo($referral->getReferrer()->email, $referral->getReferrer()->getName());
		$this->_message->setSubject($this->_translator->trans('ms.discount_reward.email.success.subject'));

		$this->_message->setView('Message:Mothership:DiscountReward::discount_reward:email:discount_create', [
			'message'  => $this->_translator->trans('ms.discount_reward.email.success.message', [
				'{%toName%}'       => $referral->getReferrer()->getName(),
				'{%discountCode%}' => $discount->code,
			]),
			'discount' => $discount,
		]);

		$this->_send();
	}
}