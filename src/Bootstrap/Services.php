<?php

namespace Message\Mothership\DiscountReward\Bootstrap;

use Message\Mothership\DiscountReward;
use Message\Cog\Bootstrap\ServicesInterface;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		// Referral types
		$services['refer.referral.types'] = $services->extend('refer.referral.types', function($types, $c) {
			$types->add($c['refer.discount.referral.types.discount_reward']);

			return $types;
		});

		$services['refer.discount.referral.types.discount_reward'] = function($c) {
			return new DiscountReward\Referral\Type\DiscountRewardType($c['refer.discount.form.referral.discount_reward']);
		};

		$services['refer.discount.form.referral.discount_reward'] = function($c) {
			return new DiscountReward\Form\ReferralType\DiscountReward;
		};

		// Referral constraints
		$services['refer.referral.constraints'] = $services->extend('refer.referral.constraints', function($constraints, $c) {
			$constraints->add($c['refer.discount.referral.constraints.minimum_order']);
			$constraints->add($c['refer.discount.referral.constraints.timeout']);

			return $constraints;
		});

		$services['refer.discount.referral.constraints.minimum_order'] = function($c) {
			return new DiscountReward\Referral\Constraint\MinimumOrder;
		};

		$services['refer.discount.referral.constraints.timeout'] = function($c) {
			return new DiscountReward\Referral\Constraint\Timeout;
		};

		// Referral triggers
		$services['refer.referral.triggers'] = $services->extend('refer.referral.triggers', function($triggers, $c) {
			$triggers->add($c['refer.discount.referral.triggers.order_create']);

			return $triggers;
		});

		$services['refer.discount.referral.triggers.order_create'] = function($c) {
			return new DiscountReward\Referral\Trigger\OrderCreate;
		};
	}
}