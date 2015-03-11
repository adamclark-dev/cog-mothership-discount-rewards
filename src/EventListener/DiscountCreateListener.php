<?php

namespace Message\Mothership\DiscountReward\EventListener;

use Message\Cog\Event\EventListener;
use Message\Cog\Event\SubscriberInterface;
use Message\Mothership\DiscountReward\Reward\Event\DiscountCreateEvent;
use Message\Mothership\DiscountReward\Reward\Event\Events as DiscountRewardEvents;
use Message\Mothership\ReferAFriend\Referral\Statuses;

/**
 * Class DiscountCreateListener
 * @package Message\Mothership\DiscountReward\EventListener
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Event listener for informing the user that they have received a discount by referring a friend
 */
class DiscountCreateListener extends EventListener implements SubscriberInterface
{
	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			DiscountRewardEvents::DISCOUNT_CREATE => [
				'updateReferral'
			]
		];
	}

	/**
	 * Inform the referrer that they have received a discount code, and mark the referral as completed
	 *
	 * @param DiscountCreateEvent $event
	 */
	public function updateReferral(DiscountCreateEvent $event)
	{
		$referral = $event->getReferral();

		$this->get('refer.discount.success_mailer')->inform($referral, $event->getDiscount());

		$referral->setStatus(Statuses::COMPLETE);
		$this->get('refer.referral.edit')->save($referral);
	}

}