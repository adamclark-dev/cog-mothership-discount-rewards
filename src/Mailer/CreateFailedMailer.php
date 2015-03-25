<?php

namespace Message\Mothership\DiscountReward\Mailer;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\DiscountReward\Reward\Exception\DiscountBuildException;

/**
 * Class CreateFailedMailer
 * @package Message\Mothership\DiscountReward\Mailer
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Mailer for informing users that their discount code could not be generated
 */
class CreateFailedMailer extends AbstractMailer
{
	/**
	 * Report to the referrer that they are eligible for a discount reward, but their discount code could not be
	 * generated.
	 *
	 * @param ReferralInterface $referral   The referral that should have completed and had a discount reward generated
	 * @param DiscountBuildException $e     The exception that was thrown upon failure to generate a discount code
	 */
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