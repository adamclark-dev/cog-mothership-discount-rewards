<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Reward\Config\Constraint\Collection;
use Message\Cog\Localisation\Translator;

class MinimumOrderFactory
{
	private $_currencies;
	private $_translator;

	public function __construct(array $currencies, Translator $translator)
	{
		$this->_currencies = $currencies;
		$this->_translator = $translator;
	}

	public function addMinimumOrderConstraints(Collection $constraints)
	{
		foreach ($this->_currencies as $currency) {
			$constraint = new MinimumOrder($this->_translator);
			$constraint->setCurrency($currency);
			$constraints->add($constraint);
		}

		return $constraints;
	}
}