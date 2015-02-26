<?php

namespace Message\Mothership\DiscountReward\Referral\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Referral\Constraint\ConstraintInterface;

class MinimumOrder implements ConstraintInterface
{
	public function getName()
	{
		return 'discount_reward.minimum_order';
	}

	public function getDisplayName()
	{
		return 'ms.discount_rewards.referral.constraints.minimum_order.name';
	}

	public function getDescription()
	{
		return 'ms.discount_rewards.referral.constraints.minimum_order.description';
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