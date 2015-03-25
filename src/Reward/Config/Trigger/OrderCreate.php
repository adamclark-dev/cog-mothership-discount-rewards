<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Trigger;

use Message\Mothership\ReferAFriend\Reward\Config\Trigger\TriggerInterface;

use Message\Mothership\Commerce\Order\Events as OrderEvents;

/**
 * Class OrderCreate
 * @package Message\Mothership\DiscountReward\Reward\Config\Trigger
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Trigger to check that an order has been created
 */
class OrderCreate implements TriggerInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward_order_create';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.triggers.order_create.name';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return 'ms.discount_reward.reward.triggers.order_create.description';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTypes()
	{
		return [
			'discount_reward',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function getEventName()
	{
		return OrderEvents::CREATE_COMPLETE;
	}
}