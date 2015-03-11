<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\RewardOptionInterface;

use Symfony\Component\Validator\Constraints;

/**
 * Class DiscountType
 * @package Message\Mothership\DiscountReward\Reward\Config\RewardOption
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Set the type of discount to generate (i.e. a percentage or a solid value)
 */
class DiscountType implements RewardOptionInterface
{
	const PERCENTAGE = 'percentage';
	const SET_AMOUNT = 'set_amount';

	/**
	 * @var string
	 */
	private $_value;

	/**
	 * @var array
	 */
	private $_choices = [
		self::PERCENTAGE => 'ms.discount_reward.reward.options.discount_type.percentage',
		self::SET_AMOUNT => 'ms.discount_reward.reward.options.discount_type.set_amount',
	];

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward_discount_type';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.options.discount_type.name';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return 'ms.discount_reward.reward.options.discount_type.description';
	}

	/**
	 * {@inheritDoc}
	 */
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

	/**
	 * {@inheritDoc}
	 */
	public function getValue()
	{
		return $this->_value;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormType()
	{
		return 'choice';
	}

	/**
	 * {@inheritDoc}
	 */
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