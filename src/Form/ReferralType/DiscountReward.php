<?php

namespace Message\Mothership\DiscountReward\Form\ReferralType;

use  Message\Mothership\ReferAFriend\Form\ReferralType\AbstractForm;

use Symfony\Component\Form;

class DiscountReward extends AbstractForm
{
	const NAME = 'refer_a_friend_discount_reward';

	public function getName()
	{
		return self::NAME;
	}

	public function buildForm(Form\FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}

	protected function _getType()
	{
		return 'discount_reward';
	}
}