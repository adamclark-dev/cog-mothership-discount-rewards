<?php

namespace Message\Mothership\DiscountReward\Reward\Config\RewardOption;

use Message\Mothership\ReferAFriend\Reward\Config\RewardOption\Collection;
use Message\Cog\Localisation\Translator;

class SetAmountFactory
{
	public function __construct(array $currencies, Translator $translator)
	{
		$this->_currencies = $currencies;
		$this->_translator = $translator;
	}

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