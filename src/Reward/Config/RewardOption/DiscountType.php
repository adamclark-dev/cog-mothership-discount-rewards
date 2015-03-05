<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\RewardOptionInterface;

use Symfony\Component\Validator\Constraints;

class DiscountType implements RewardOptionInterface
{
	const PERCENTAGE = 'percentage';
	const SET_AMOUNT = 'set_amount';

	private $_value;

	private $_choices = [
		self::PERCENTAGE => 'ms.discount_reward.reward.options.discount_type.percentage',
		self::SET_AMOUNT => 'ms.discount_reward.reward.options.discount_type.set_amount',
	];

	public function getName()
	{
		return 'discount_reward_discount_type';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.options.discount_type.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.reward.options.discount_type.description';
	}

	public function setValue($value)
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException('Value must be a string');
		}
		if (!array_key_exists($value, $this->_choices)) {
			throw new \LogicException('`' . $value . '` is not a valid value');
		}

		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function getFormType()
	{
		return 'choice';
	}

	public function getFormOptions()
	{
		return [
			'multiple' => false,
			'expanded' => true,
			'choices'  => $this->_choices,
			'constraints' => [
				new Constraints\NotBlank,
			],
		];
	}
}