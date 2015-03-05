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
	private $_value;
	private $_currency;

	private $_translator;

	public function __construct(Translator $translator)
	{
		$this->_translator = $translator;
	}

	public function getName()
	{
		return 'discount_reward_minimum_order_' . $this->_currency;
	}

	public function getDisplayName()
	{
		return $this->_translator->trans('ms.discount_reward.reward.constraints.minimum_order.name') . ' (' . $this->_currency . ')';
	}

	public function getDescription()
	{
		return $this->_translator->trans('ms.discount_reward.reward.constraints.minimum_order.description') . ' (' . $this->_currency . ')';
	}

	public function setValue($value)
	{
		$this->_value = round((float) $value, 2);
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function setCurrency($currency)
	{
		if (!is_string($currency)) {
			throw new \InvalidArgumentException('Currency must be a string!');
		}

		$this->_currency = $currency;
	}

	public function getCurrency()
	{
		return $this->_currency;
	}

	public function getFormType()
	{
		return 'money';
	}

	public function getFormOptions()
	{
		return [
			'currency'    => $this->_currency,
			'constraints' => [
				new Constraints\GreaterThan(['value' => 0]),
			]
		];
	}

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