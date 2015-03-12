<?php

namespace Message\Mothership\DiscountReward\Reward\Event;

use Message\Mothership\Discount\Discount\Discount;
use Message\Mothership\ReferAFriend\Referral\Event\ReferralEvent;

/**
 * Class DiscountCreateEvent
 * @package Message\Mothership\DiscountReward\Reward\Event
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Event to be fired upon the creation of a discount code as the result of a completed referral
 */
class DiscountCreateEvent extends ReferralEvent
{
	/**
	 * @var Discount
	 */
	private $_discount;

	/**
	 * Set the newly created discount
	 *
	 * @param Discount $discount
	 */
	public function setDiscount(Discount $discount)
	{
		$this->_discount = $discount;
	}

	/**
	 * Get the newly created discount
	 *
	 * @return Discount
	 */
	public function getDiscount()
	{
		return $this->_discount;
	}
}