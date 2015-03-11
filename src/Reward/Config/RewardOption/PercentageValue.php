<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\RewardOptionInterface;

use Symfony\Component\Validator\Constraints;

/**
 * Class PercentageValue
 * @package Message\Mothership\DiscountReward\Reward\Config\RewardOption
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Set the percentage value assigned to the discount
 */
class PercentageValue implements RewardOptionInterface
{
	/**
	 * @var float
	 */
	private $_value;

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward_percentage_value';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.options.percentage_value.name';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return 'ms.discount_reward.reward.options.percentage_value.description';
	}

	/**
	 * {@inheritDoc}
	 */
	public function setValue($value)
	{
		if (!is_numeric($value)) {
			return new \LogicException('Value must be numeric!');
		}

		$this->_value = (float) $value;
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
		return 'number';
	}

	/**
	 * {@inheritDoc}
	 */
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