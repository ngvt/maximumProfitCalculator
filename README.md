### Instructions
Instantiate the MaximumProfitCalculatorTest and set the following data:
bid_data (from the excel sheet given as an array )

$maximumProfitCalculator = new MaximumProfitCalculator();
$maximumProfitCalculator->setBidData($this->getRawCompanyData());
$maximumProfitCalculator->setCostPerUnitToProduce(self::COST_PER_UNIT_TO_PRODUCE);
$maximumProfitCalculator->setCurrentInventoryAmount(19);
$results = $maximumProfitCalculator->findClientsToSellTo();

### Tips 

##### Show Your Work
Use commits and commit messages liberally to give us insight into your thought process. Every code change has a story, it ebbs 
and flows and there are fluctuations. You understand things differently at the end than when you first started. That's ok! 
We want to see that story, and in fact, we encourage it. We don't want a single commit with "updates" as the message 
because that doesn't help us.

##### Don't Over Scope
Creating new methods and helper functions in the coding challenge is completely acceptable and encouraged. Be wary if you feel
the need to create new classes or spin up an entire framework around the challenge. We want to see your coding skills *and*
your ability to understand an abstract problem and still make meaningful contributions. 

##### Clean Code
The code provided in the challenge is **actual production** code. It might be inconsistent, confusing, or ugly to look at, but
it works. Part of this challenge (*hint, hint*) is for you to show us what consistent, clear, and aesthetically pleasing code 
looks like to you.  