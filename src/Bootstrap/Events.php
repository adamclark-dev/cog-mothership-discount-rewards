<?php

namespace Message\Mothership\DiscountReward\Bootstrap;

use Message\Mothership\DiscountReward\EventListener;
use Message\Cog\Bootstrap\EventsInterface;

class Events implements EventsInterface
{
	public function registerEvents($dispatcher)
	{
		$dispatcher->addSubscriber(new EventListener\DiscountCreateListener);
		$dispatcher->addSubscriber(new EventListener\DiscountRewardListener);
	}
}