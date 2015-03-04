<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Reward\Config\Constraint\Collection;
use Message\Cog\Localisation\Translator;

/**
 * Class MinimumOrderFactory
 * @package Message\Mothership\DiscountReward\Reward\Config\Constraint
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Class for creating a new instance of the MinimumOrder constraint for each registered currency
 */
class MinimumOrderFactory
{
	/**
	 * @var array
	 */
	private $_currencies;

	/**
	 * @var Translator
	 */
	private $_translator;

	public function __construct(array $currencies, Translator $translator)
	{
		$this->_currencies = $currencies;
		$this->_translator = $translator;
	}

	/**
	 * @param Collection $constraints
	 *
	 * @return Collection
	 */
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