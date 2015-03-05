<?php

namespace Message\Mothership\DiscountReward\Reward\Type;

use Message\Mothership\ReferAFriend\Reward\Type\TypeInterface;

class DiscountRewardType implements TypeInterface
{
	private $_currencies;

	public function __construct(array $currencies)
	{
		$this->_currencies = $currencies;
	}

	public function getName()
	{
		return 'discount_reward';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.types.discount_reward.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.reward.types.discount_reward.description';
	}

	public function validTriggers()
	{
		return [
			'discount_reward_order_create'
		];
	}

	public function validConstraints()
	{
		$constraints =  [
			'discount_reward_timeout',
		];

		foreach ($this->_currencies as $currency) {
			$constraints[] = 'discount_reward_minimum_order_' . $currency;
		}

		return $constraints;
	}

	public function validRewardOptions()
	{
		$rewardOptions = [
			'discount_reward_discount_type',
			'discount_reward_percentage_value',
		];

		foreach ($this->_currencies as $currency) {
			$rewardOptions[] = 'discount_reward_set_amount_' . $currency;
		}

		return $rewardOptions;
	}
}