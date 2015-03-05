<?php

namespace Message\Mothership\DiscountReward\Bootstrap;

use Message\Mothership\DiscountReward;
use Message\Cog\Bootstrap\ServicesInterface;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		// Reward types
		$services['refer.reward.types'] = $services->extend('refer.reward.types', function($types, $c) {
			$types->add($c['refer.discount.reward.types.discount_reward']);

			return $types;
		});

		$services['refer.discount.reward.types.discount_reward'] = function($c) {
			return new DiscountReward\Reward\Type\DiscountRewardType($c['cfg']->currency->supportedCurrencies);
		};

		// Reward constraints
		$services['refer.reward.config.constraints'] = $services->extend('refer.reward.config.constraints', function($constraints, $c) {
			$constraints->add($c['refer.discount.reward.config.constraints.timeout']);

			$constraints = $c['refer.discount.reward.config.constraints.minimum_order_factory']->addMinimumOrderConstraints($constraints);

			return $constraints;
		});

		$services['refer.discount.reward.config.constraints.minimum_order_factory'] = function($c) {
			return new DiscountReward\Reward\Config\Constraint\MinimumOrderFactory(
				$c['cfg']->currency->supportedCurrencies,
				$c['translator']
			);
		};

		$services['refer.discount.reward.config.constraints.timeout'] = function($c) {
			return new DiscountReward\Reward\Config\Constraint\Timeout($c['refer.referral.edit']);
		};

		// Reward triggers
		$services['refer.reward.config.triggers'] = $services->extend('refer.reward.config.triggers', function($triggers, $c) {
			$triggers->add($c['refer.discount.reward.config.triggers.order_create']);

			return $triggers;
		});

		$services['refer.discount.reward.config.triggers.order_create'] = function($c) {
			return new DiscountReward\Reward\Config\Trigger\OrderCreate;
		};

		// Reward options
		$services['refer.reward.config.reward_options'] = $services->extend('refer.reward.config.reward_options', function($rewardOptions, $c) {
			$rewardOptions->add($c['refer.discount.reward.config.reward_options.discount_type']);
			$rewardOptions->add($c['refer.discount.reward.config.reward_options.percentage_value']);

			$rewardOptions = $c['refer.discount.reward.config.reward_options.set_amount_factory']->addSetAmountRewardOptions($rewardOptions);

			return $rewardOptions;
		});

		$services['refer.discount.reward.config.reward_options.discount_type'] = function($c) {
			return new DiscountReward\Reward\Config\RewardOption\DiscountType;
		};

		$services['refer.discount.reward.config.reward_options.percentage_value'] = function($c) {
			return new DiscountReward\Reward\Config\RewardOption\PercentageValue;
		};

		$services['refer.discount.reward.config.reward_options.set_amount_factory'] = function($c) {
			return new DiscountReward\Reward\Config\RewardOption\SetAmountFactory(
				$c['cfg']->currency->supportedCurrencies,
				$c['translator']
			);
		};

		// Discounts
		$services['refer.discount.discount_builder'] = function($c) {
			return new DiscountReward\Reward\DiscountBuilder(
				$c['discount.loader'],
				$c['security.string-generator']
			);
		};

		// Mailers
		$services['refer.discount.success_mailer'] = $services->factory(function($c) {
			return new DiscountReward\Mailer\DiscountCreatedMailer($c['mail.dispatcher'], $c['mail.message'], $c['translator']);
		});

		$services['refer.discount.failure_mailer'] = $services->factory(function($c) {
			return new DiscountReward\Mailer\CreateFailedMailer($c['mail.dispatcher'], $c['mail.message'], $c['translator']);
		});

	}
}