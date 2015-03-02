<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Reward\Config\Constraint\ConstraintInterface;

class MinimumOrder implements ConstraintInterface
{
	private $_value;

	public function getName()
	{
		return 'discount_reward_minimum_order';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.referral.constraints.minimum_order.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.referral.constraints.minimum_order.description';
	}

	public function setValue($value)
	{
		$this->_value;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function getFormType()
	{
		return 'text';
	}

	public function getFormOptions()
	{
		return [];
	}

	public function validate(ReferralInterface $referral)
	{

	}
}