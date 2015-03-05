<?php

namespace Message\Mothership\DiscountReward\Reward;

use Message\Mothership\ReferAFriend\Referral\ReferralInterface;
use Message\Mothership\DiscountReward\Reward\Config\RewardOption\DiscountType;
use Message\Mothership\Discount\Discount\Discount;
use Message\Mothership\Discount\Discount\Loader as DiscountLoader;
use Message\Cog\Security\StringGenerator;

/**
 * Class DiscountBuilder
 */
class DiscountBuilder
{
	const LIMIT = 20;

	const LENGTH = 8;

	/**
	 * @var DiscountLoader
	 */
	private $_loader;

	/**
	 * @var StringGenerator
	 */
	private $_stringGenerator;

	/**
	 * @var array
	 */
	private $_codes = [];

	public function __construct(DiscountLoader $loader, StringGenerator $stringGenerator)
	{
		$this->_loader          = $loader;
		$this->_stringGenerator = $stringGenerator;
	}

	public function build(ReferralInterface $referral)
	{
		$discount = new Discount;
		$discount->code   = $this->_getCode();
		$discount->emails = [$referral->getReferrer()->email];

		$rewardOptions = $referral->getRewardConfig()->getRewardOptions();

		$type = $rewardOptions->get('discount_reward_discount_type')->getValue();

		switch ($type) {
			case DiscountType::SET_AMOUNT:
				$discount->discountAmounts = [];
				foreach ($rewardOptions as $rewardOption) {
					if ($rewardOption instanceof Config\RewardOption\SetAmount) {
						$discount->discountAmounts[$rewardOption->getCurrency()] = $rewardOption->getValue();
					}
				}
				break;
			case DiscountType::PERCENTAGE:
				$discount->percentage = $rewardOptions->get('discount_reward_percentage_value')->getValue();
				break;
			default:
				throw new Exception\DiscountBuildException('No valid discount type set on discount referral');
		}

		return $discount;
	}

	private function _getCode()
	{
		$code = $this->_generateCode();
		if (false === $this->_loader->getByCode($code)) {
			return $code;
		}

		$this->_codes[] = $code;

		if (count($this->_codes) > self::LIMIT) {
			throw new \RuntimeException('Could not create a unique discount code in ' . self::LIMIT . ' attempts');
		}

		return $this->_getCode();
	}

	private function _generateCode()
	{
		return $this->_stringGenerator->setPattern('/^[A-HJ-KM-NP-Z2-9]+$/')->generate(self::LENGTH);
	}
}