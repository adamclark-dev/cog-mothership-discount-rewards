<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Reward\Config\Constraint\ConstraintInterface;

use Message\Cog\Event\Event;

use Symfony\Component\Validator\Constraints;

/**
 * Class Timeout
 * @package Message\Mothership\DiscountReward\Reward\Config\Constraint
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * Validate the the time of the order creation
 */
class Timeout implements ConstraintInterface
{
	private $_value;

	public function getName()
	{
		return 'discount_reward_timeout';
	}

	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.constraints.timeout.name';
	}

	public function getDescription()
	{
		return 'ms.discount_reward.reward.constraints.timeout.description';
	}

	public function setValue($value)
	{
		if (!is_numeric($value) || (int) $value != $value) {
			throw new \LogicException('Value must be a whole number');
		}

		$this->_value = (int) $value;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function getFormType()
	{
		return 'text';
	}

	public function getFormOptions()
	{
		return [
			'constraints' => [
				new Constraints\GreaterThan(['value' => 0]),
			]
		];
	}

	public function isValid(ReferralInterface $referral, Event $event)
	{

	}
}