<?php

namespace Message\Mothership\DiscountReward\Bootstrap;

use Message\Mothership\DiscountReward;
use Message\Cog\Bootstrap\ServicesInterface;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		// Referral types
		$services['refer.reward.types'] = $services->extend('refer.reward.types', function($types, $c) {
			$types->add($c['refer.discount.reward.types.discount_reward']);

			return $types;
		});

		$services['refer.discount.reward.types.discount_reward'] = function($c) {
			return new DiscountReward\Reward\Type\DiscountRewardType($c['refer.discount.form.reward.discount_reward']);
		};

		// Referral constraints
		$services['refer.reward.config.constraints'] = $services->extend('refer.reward.config.constraints', function($constraints, $c) {
			$constraints->add($c['refer.discount.reward.config.constraints.minimum_order']);

			return $constraints;
		});

		$services['refer.discount.reward.config.constraints.minimum_order'] = function($c) {
			return new DiscountReward\Reward\Config\Constraint\MinimumOrder;
		};

		// Referral triggers
		$services['refer.reward.config.triggers'] = $services->extend('refer.reward.config.triggers', function($triggers, $c) {
			$triggers->add($c['refer.discount.reward.config.triggers.order_create']);

			return $triggers;
		});

		$services['refer.discount.reward.config.triggers.order_create'] = function($c) {
			return new DiscountReward\Reward\Config\Trigger\OrderCreate;
		};
	}
}