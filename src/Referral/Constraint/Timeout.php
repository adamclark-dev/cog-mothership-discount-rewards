<?php

namespace Message\Mothership\DiscountReward\Referral\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Referral\Constraint\ConstraintInterface;

class Timeout implements ConstraintInterface
{
	public function getName()
	{
		return 'discount_reward.timeout';
	}

	public function getDisplayName()
	{
		return 'ms.discount_rewards.referral.constraints.timeout.name';
	}

	public function getDescription()
	{
		return 'ms.discount_rewards.referral.constraints.timeout.description';
	}

	public function getTypes()
	{
		return [
			'discount_reward',
		];
	}

	public function validate(ReferralInterface $referral)
	{

	}
}