<?php

namespace Message\Mothership\DiscountReward\Bootstrap;

use Message\Mothership\DiscountReward;
use Message\Cog\Bootstrap\ServicesInterface;

class Services implements ServicesInterface
{
	public function registerServices($services)
	{
		$services['refer.referral.types'] = $this->extend('refer.referral.types', function($types, $c) {
			$types->add(
				$c['refer.discount.referral.types.discount_reward']
			);

			return $types;
		});

		$services['refer.discount.referral.types.discount_reward'] = function($c) {
			return new DiscountReward\Referral\Type\DiscountRewardType($c['refer.discount.form.referral.discount_reward']);
		};

		$services['refer.discount.form.referral.discount_reward'] = function($c) {
			return new DiscountReward\Form\ReferralType\DiscountReward;
		};
	}
}