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

/**
 * Class DiscountRewardListener
 * @package Message\Mothership\DiscountReward\EventListener
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Event listener for listening to when a referral as been fulfilled
 */
class DiscountRewardListener extends EventListener implements SubscriberInterface
{
	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			OrderEvents::CREATE_COMPLETE => [
				'giveReward'
			],
		];
	}

	/**
	 * Listen to when an order has been completed and check to see whether the user that made the order has been
	 * referred. If they have and the reward creation has triggered, it will then validate the order fulfills
	 * any rules set by the constraints.
	 *
	 * If the referral is valid and fulfills the specifications of the reward configuration, a discount code will be
	 * generated and an event will be fired. If for some reason a discount code not be generated, the referrer
	 * will be informed that they are eligible for a discount but its generation was not successful, and that they
	 * should get in touch with the vendor. The referral will be marked with an error status.
	 *
	 * @param OrderEvent $event
	 */
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
}