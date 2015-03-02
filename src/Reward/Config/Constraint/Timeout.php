<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Reward\Config\Constraint\ConstraintInterface;

class Timeout implements ConstraintInterface
{
	private $_value;

	public function getName()
	{
		return 'discount_reward_timeout';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.referral.constraints.timeout.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.referral.constraints.timeout.description';
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