<?php

namespace Message\Mothership\DiscountReward\EventListener;

use Message\Mothership\DiscountReward\Reward\Config\Constraint\MinimumOrder;
use Message\Mothership\DiscountReward\Reward\Event\DiscountCreateEvent;
use Message\Mothership\DiscountReward\Reward\Event\Events as DiscountRewardEvents;
use Message\Mothership\DiscountReward\Reward\Exception\DiscountBuildException;
use Message\Cog\Event\EventListener;
use Message\Cog\Event\SubscriberInterface;
use Message\Mothership\Commerce\Order\Events as OrderEvents;
use Message\Mothership\Commerce\Order\Event\Event as OrderEvent;
use Message\Mothership\ReferAFriend\Referral\Statuses;

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

		$referrals = $this->get('refer.referral.loader')->getByEmail($order->user->email, Statuses::PENDING);

		if (empty($referrals)) {
			return;
		}

		foreach ($referrals as $referral) {
			if ($referral->hasTriggered(OrderEvents::CREATE_COMPLETE)) {
				foreach ($referral->getRewardConfig()->getConstraints() as $constraint) {
					// Don't bother checking minimum order if currency does not match
					if ($constraint instanceof MinimumOrder && $order->currencyID !== $constraint->getCurrency()) {
						continue;
					}

					if (false === $constraint->isValid($referral, $event)) {
						return;
					}
				}
			}

			try {
				$discount = $this->get('refer.discount.discount_builder')->build($referral);
				$discount = $this->get('discount.create')->create($discount);

				if ($discount->id) {
					// Save again because the emails don't save on create.
					$discount = $this->get('discount.edit')->save($discount);
					$event = new DiscountCreateEvent;
					$event->setReferral($referral);
					$event->setDiscount($discount);

					$this->get('event.dispatcher')->dispatch(
						DiscountRewardEvents::DISCOUNT_CREATE,
						$event
					);
				} else {
					throw new DiscountBuildException('Could not save new discount to database');
				}
			} catch (DiscountBuildException $e) {
				$this->get('refer.discount.failure_mailer')->report($referral, $e);
				$referral->setStatus(Statuses::ERROR);
				$this->get('refer.referral.edit')->save($referral);
			}
		}
	}
}