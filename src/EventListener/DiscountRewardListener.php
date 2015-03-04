<?php

namespace Message\Mothership\DiscountReward\EventListener;

use Message\Mothership\DiscountReward\Reward\Config\Constraint\MinimumOrder;
use Message\Cog\Event\EventListener;
use Message\Cog\Event\SubscriberInterface;
use Message\Mothership\Commerce\Order\Events as OrderEvents;
use Message\Mothership\Commerce\Order\Event\Event as OrderEvent;

class DiscountRewardListener extends EventListener implements SubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return [
			OrderEvents::CREATE_COMPLETE => [
				'giveReward'
			],
		];
	}

	public function giveReward(OrderEvent $event)
	{
		$order = $event->getOrder();

		$referrals = $this->get('refer.referral.loader')->getByEmail($order->user->email);

		if (empty($referrals)) {
			return;
		}

		foreach ($referrals as $referral) {
			if ($referral->hasTriggered(OrderEvents::CREATE_COMPLETE)) {
				foreach ($referral->getRewardConfig()->getConstraints() as $constraint) {
					// Don't bother checking minimum order if currency does not match
					if ($constraint instanceof MinimumOrder && $order->currency !== $constraint->getCurrency()) {
						continue;
					}

					if (false === $constraint->isValid($referral, $event)) {
						return;
					}
				}
			}

			$this->get('refer.discount.reward.discount_creator')->createCode($referral);
		}
	}
}