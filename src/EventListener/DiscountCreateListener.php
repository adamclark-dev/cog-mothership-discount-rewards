<?php

namespace Message\Mothership\DiscountReward\EventListener;

use Message\Cog\Event\EventListener;
use Message\Cog\Event\SubscriberInterface;
use Message\Mothership\DiscountReward\Reward\Event\DiscountCreateEvent;
use Message\Mothership\DiscountReward\Reward\Event\Events as DiscountRewardEvents;
use Message\Mothership\ReferAFriend\Referral\Statuses;

class DiscountCreateListener extends EventListener implements SubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return [
			DiscountRewardEvents::DISCOUNT_CREATE => [
				'updateReferral'
			]
		];
	}

	public function updateReferral(DiscountCreateEvent $event)
	{
		$referral = $event->getReferral();

		$this->get('refer.discount.success_mailer')->inform($referral, $event->getDiscount());

		$referral->setStatus(Statuses::COMPLETE);
		$this->get('refer.referral.edit')->save($referral);
	}

}