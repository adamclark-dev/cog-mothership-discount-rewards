<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\RewardOptionInterface;
use Message\Cog\Localisation\Translator;

use Symfony\Component\Validator\Constraints;

/**
 * Class SetAmount
 * @package Message\Mothership\DiscountReward\Reward\Config\RewardOption
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Set the solid amount that the discount applies to for the specified currency.
 */
class SetAmount implements RewardOptionInterface
{
	/**
	 * @var float
	 */
	private $_value;

	/**
	 * @var string
	 */
	private $_currency;

	/**
	 * @var Translator
	 */
	private $_translator;

	public function __construct(Translator $translator)
	{
		$this->_translator = $translator;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward_set_amount_' . $this->_currency;
	}

	/**
	 * Translates display name here and appends the currency ID
	 *
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return $this->_translator->trans('ms.discount_reward.reward.options.set_amount.name') . ' (' . $this->_currency . ')';
	}

	/**
	 * Translates the description here and appends the currency ID
	 *
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return $this->_translator->trans('ms.discount_reward.reward.options.set_amount.description') . ' (' . $this->_currency . ')';
	}

	/**
	 * {@inheritDoc}
	 */
	public function setValue($value)
	{
		$this->_value = round((float) $value, 2);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getValue()
	{
		return $this->_value;
	}

	/**
	 * Set the currency ID that the amount applies to
	 *
	 * @param string $currency
	 * @throws \InvalidArgumentException    Throws exception if currency ID is not a string
	 */
	public function setCurrency($currency)
	{
		if (!is_string($currency)) {
			throw new \InvalidArgumentException('Currency must be a string!');
		}

		$this->_currency = $currency;
	}

	/**
	 * Get the currency ID that the amount applies to
	 *
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->_currency;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormType()
	{
		return 'money';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormOptions()
	{
		return [
			'currency' => $this->_currency,
			'constraints' => [
				new Constraints\GreaterThan(['value' => 0]),
			],
			'attr' => [
				'class' => 'set-amount'
			],
		];
	}
}