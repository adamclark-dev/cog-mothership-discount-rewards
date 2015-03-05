<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\RewardOptionInterface;

use Symfony\Component\Validator\Constraints;

class PercentageValue implements RewardOptionInterface
{
	private $_value;

	public function getName()
	{
		return 'discount_reward_percentage_value';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.options.percentage_value.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.reward.options.percentage_value.description';
	}

	public function setValue($value)
	{
		if (!is_numeric($value)) {
			return new \LogicException('Value must be numeric!');
		}

		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function getFormType()
	{
		return 'number';
	}

	public function getFormOptions()
	{
		return [
			'constraints' => [
				new Constraints\GreaterThan(['value' => 0]),
			],
			'attr' => [
				'class' => 'percentage'
			],
		];
	}
}