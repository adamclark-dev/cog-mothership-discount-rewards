<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\RewardOptionInterface;
use Message\Cog\Localisation\Translator;

use Symfony\Component\Validator\Constraints;

class SetAmount implements RewardOptionInterface
{
	private $_value;
	private $_currency;

	private $_translator;

	public function __construct(Translator $translator)
	{
		$this->_translator = $translator;
	}

	public function getName()
	{
		return 'discount_reward_set_amount_' . $this->_currency;
	}

	public function getDisplayName()
	{
		return $this->_translator->trans('ms.discount_reward.reward.options.set_amount.name') . ' (' . $this->_currency . ')';
	}

	public function getDescription()
	{
		return $this->_translator->trans('ms.discount_reward.reward.options.set_amount.description') . ' (' . $this->_currency . ')';
	}

	public function setValue($value)
	{
		$this->_value = round((float) $value, 2);
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function setCurrency($currency)
	{
		if (!is_string($currency)) {
			throw new \InvalidArgumentException('Currency must be a string!');
		}

		$this->_currency = $currency;
	}

	public function getCurrency()
	{
		return $this->_currency;
	}

	public function getFormType()
	{
		return 'money';
	}

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