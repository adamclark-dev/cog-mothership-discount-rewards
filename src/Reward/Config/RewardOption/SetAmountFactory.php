<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\Collection;
use Message\Cog\Localisation\Translator;

/**
 * Class SetAmountFactory
 * @package Message\Mothership\DiscountReward\Reward\Config\RewardOption
 *
 * @author Thomas Marchant <thomas@mothership.ec>
 *
 * Class for creating a new instance of SetAmount for each registered currency and adding them to the main RewardOption
 * collection
 */
class SetAmountFactory
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
	 * Loop through currencies and create a new instance of SetAmount for each one, with the currency applied
	 *
	 * @param Collection $rewardOptions
	 *
	 * @return Collection
	 */
	public function addSetAmountRewardOptions(Collection $rewardOptions)
	{
		foreach ($this->_currencies as $currency) {
			$option = new SetAmount($this->_translator);
			$option->setCurrency($currency);
			$rewardOptions->add($option);
		}

		return $rewardOptions;
	}
}