<?php

namespace Message\Mothership\DiscountReward\Referral\Type;

use Message\Mothership\ReferAFriend\Referral\Type\TypeInterface;

class DiscountRewardType implements TypeInterface
{
	public function getName()
	{
		return 'discount_reward';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.referral.types.discount_reward.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.referral.types.discount_reward.description';
	}

	public function validTriggers()
	{
		return [
			'discount_reward_order_create'
		];
	}

	public function validConstraints()
	{
		return [
			'discount_reward_minimum_order',
			'discount_reward_timeout',
		];
	}
}