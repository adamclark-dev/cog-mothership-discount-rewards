<?php

namespace Message\Mothership\DiscountReward\Reward\Config\Constraint;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\ReferAFriend\Reward\Config\Constraint\ConstraintInterface;

use Message\Mothership\Commerce\Order\Event\Event as OrderEvent;
use Message\Cog\Event\Event;
use Message\Cog\Localisation\Translator;

use Symfony\Component\Validator\Constraints;

/**
 * Class MinimumOrder
 * @package Message\Mothership\DiscountReward\Reward\Config\Constraint
 *
 * @author Thomas Marchant <thomas@message.co.uk>
 *
 * A more dynamic constraint that validates the amount spend on an order
 */
class MinimumOrder implements ConstraintInterface
{
	/**
	 * @var float
	 */
	private $_value;

	/**
	 * @var string
	 */
	private $_currency;

	/**
	 * @var Translator
	 */
	private $_translator;

	public function __construct(Translator $translator)
	{
		$this->_translator = $translator;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'discount_reward_minimum_order_' . $this->_currency;
	}

	/**
	 * Translates the display name here and appends the currency ID
	 *
	 * {@inheritDoc}
	 */
	public function getDisplayName()
	{
		return $this->_translator->trans('ms.discount_reward.reward.constraints.minimum_order.name') . ' (' . $this->_currency . ')';
	}

	/**
	 * Translates the description here and appends the currency ID
	 *
	 * {@inheritDoc}
	 */
	public function getDescription()
	{
		return $this->_translator->trans('ms.discount_reward.reward.constraints.minimum_order.description') . ' (' . $this->_currency . ')';
	}

	/**
	 * {@inheritDoc}
	 */
	public function setValue($value)
	{
		$this->_value = round((float) $value, 2);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getValue()
	{
		return $this->_value;
	}

	/**
	 * Set the currency ID that the value applies to
	 *
	 * @param string $currency
	 * @throwns \InvalidArgumentException  Throws exception if currency ID is not a string
	 */
	public function setCurrency($currency)
	{
		if (!is_string($currency)) {
			throw new \InvalidArgumentException('Currency must be a string!');
		}

		$this->_currency = $currency;
	}

	/**
	 * Get the currency ID that the value applies to
	 */
	public function getCurrency()
	{
		return $this->_currency;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormType()
	{
		return 'money';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFormOptions()
	{
		return [
			'currency'    => $this->_currency,
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

		$order = $event->getOrder();

		if ($order->currencyID !== $this->_currency) {
			throw new \LogicException('Order currency does not match minimum order constraint currency');
		}

		return $order->totalGross >= $this->getValue();
	}
}