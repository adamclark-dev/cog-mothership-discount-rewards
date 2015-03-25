# Mothership Refer a Friend: Discount Rewards

The `Message\Mothership\DiscountReward` cogule is a library that plugs into the <a href="https://github.com/mothership-ec/cog-mothership-refer-a-friend"">Refer a Friend</a> cogule, allowing users to receive a discount reward for referring someone to the e-commerce site.

This cogule includes:

## Reward types:

+ **Discount reward** - A discount reward for the referrer.

## Triggers:

+ **Order create** - The reward is triggered when the referred user creates an order, i.e. they buy something. The specific event that is being listened for is the `OrderEvents::CREATE_COMPLETE` event.

## Constraints:

+ **Minimum order** - A magic constraint that will be cloned by the `MinumumOrderFactory` for each currency registered in the `currency.yml` config file. This sets how much the total gross of the order must be for the reward creation to be triggered.
+ **Timeout** - A constraint that determines how long (in days) the referred user has to create an order. If the referral has timed out, it will update the status to `expired`.
	+ **TODO:** Create cron task to automatically update timeouts

## Reward Options

+ **Discount type** - Set whether the discount is a percentage value or a specific amount.
+ **Percentage value** - If the discount type is set to Percentage, this sets the value of that percentage
+ **Set amount** - A magic reward type that will be cloned by the `SetAmountFactory` for each currency registered in the `currency.yml` config file. If the discount type is set to a specific amount, this determines what value the discount has, for each currency.