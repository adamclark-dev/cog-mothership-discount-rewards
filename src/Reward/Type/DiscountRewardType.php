<?php

namespace Message\Mothership\DiscountReward\Reward\Type;

use Message\Mothership\ReferAFriend\Reward\Type\TypeInterface;

/**
 * Class DiscountRewardType
 * @package Message\Mothership\DiscountReward\Reward\Type
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * A reward type for rewarding referrers with a discount code
 */
class DiscountRewardType implements TypeInterface
{
	/**
	 * @var array
	 */
	private $_currencies;

	public function __construct(array $currencies)
	{
		$this->_currencies = $currencies;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.types.discount_reward.name';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return 'ms.discount_reward.reward.types.discount_reward.description';
	}

	/**
	 * {@inheritDoc}
	 */
	public function validTriggers()
	{
		return [
			'discount_reward_order_create'
		];
	}

	/**
	 * {@inheritDoc}
	 */
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

	/**
	 * {@inheritDoc}
	 */
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