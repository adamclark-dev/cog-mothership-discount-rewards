<?php

namespace Message\Mothership\DiscountReward\Reward\Event;

use Message\Mothership\Discount\Discount\Discount;
use Message\Mothership\ReferAFriend\Referral\Event\ReferralEvent;

class DiscountCreateEvent extends ReferralEvent
{
	/**
	 * @var Discount
	 */
	private $_discount;

	public function setDiscount($discount)
	{
		$this->_discount = $discount;
	}

	public function getDiscount()
	{
		return $this->_discount;
	}
}