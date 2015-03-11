<?php

namespace Message\Mothership\DiscountReward\Bootstrap;

use Message\Mothership\DiscountReward\EventListener;
use Message\Cog\Bootstrap\EventsInterface;

/**
 * Class Events
 * @package Message\Mothership\DiscountReward\Bootstrap
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Register event listeners for handling discount referring and creation
 */
class Events implements EventsInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function registerEvents($dispatcher)
	{
		$dispatcher->addSubscriber(new EventListener\DiscountCreateListener);
		$dispatcher->addSubscriber(new EventListener\DiscountRewardListener);
	}
}