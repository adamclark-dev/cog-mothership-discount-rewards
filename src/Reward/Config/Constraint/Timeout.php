<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Referral\Edit as ReferralEdit;
use Message\Mothership\ReferAFriend\Referral\Statuses;
use Message\Mothership\ReferAFriend\Reward\Config\Constraint\ConstraintInterface;

use Message\Mothership\Commerce\Order\Event\Event as OrderEvent;
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
	/**
	 * @var Number of seconds until timeout
	 */
	private $_value;

	/**
	 * @var ReferralEdit
	 */
	private $_referralEdit;

	public function __construct(ReferralEdit $referralEdit)
	{
		$this->_referralEdit;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward_timeout';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return 'ms.discount_reward.reward.constraints.timeout.name';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return 'ms.discount_reward.reward.constraints.timeout.description';
	}

	/**
	 * {@inheritDoc}
	 */
	public function setValue($value)
	{
		if (!is_numeric($value) || (int) $value != $value) {
			throw new \LogicException('Value must be a whole number');
		}

		$this->_value = (int) $value * 86400;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getValue()
	{
		return (int) $this->_value / 86400;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormType()
	{
		return 'integer';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormOptions()
	{
		return [
			'constraints' => [
				new Constraints\GreaterThan(['value' => 0]),
			]
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function isValid(ReferralInterface $referral, Event $event)
	{
		if (!$event instanceof OrderEvent) {
			throw new \LogicException('Event should be an instance of OrderEvent');
		}

		$orderDate    = $event->getOrder()->authorship->createdAt()->format('Y-m-d');
		$referralDate = $referral->getCreatedAt()->format('Y-m-d');

		$diff = strtotime($orderDate) - strtotime($referralDate);

		$timedOut = $diff <= $this->_value;

		if (false === $timedOut) {
			$referral->setStatus(Statuses::EXPIRED);
			$this->_referralEdit->save($referral);
		}
	}
}