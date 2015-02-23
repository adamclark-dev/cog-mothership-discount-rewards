<?php

namespace Message\Mothership\DiscountReward\Referral\Type;

use Message\Mothership\ReferAFriend\Referral\Type\TypeInterface;
use Message\Mothership\ReferAFriend\Form\ReferralType\AbstractForm;

class DiscountRewardType implements TypeInterface
{
	/**
	 * @var AbstractForm
	 */
	private $_form;

	public function __construct(AbstractForm $form)
	{
		$this->_form = $form;
	}

	public function getName()
	{
		return 'discount_reward';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.referral.type.discount_reward.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.referral.type.discount_reward.description';
	}

	public function getForm()
	{
		return $this->_form;
	}

	public function allowTriggers()
	{
		return true;
	}

	public function allowConstraints()
	{
		return true;
	}
}