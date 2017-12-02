<?php

use PHPUnit\Framework\TestCase;
require 'MaximumProfitCalculator.php';

class MaximumProfitCalculatorTest extends TestCase
{   

    const COST_PER_UNIT_TO_PRODUCE = .5;
    
    public function getRawCompanyData() {
        $data_array = [];
        $data_array[] = $this->generateSingleCompanyData("a", 1, 1);
        $data_array[] = $this->generateSingleCompanyData("b", 2, 5);
        $data_array[] = $this->generateSingleCompanyData("c", 3, 8);
        $data_array[] = $this->generateSingleCompanyData("d", 4, 9);
        $data_array[] = $this->generateSingleCompanyData("e", 5, 10);
        $data_array[] = $this->generateSingleCompanyData("f", 6, 17);
        $data_array[] = $this->generateSingleCompanyData("g", 7, 17);
        $data_array[] = $this->generateSingleCompanyData("h", 8, 20);
        $data_array[] = $this->generateSingleCompanyData("i", 9, 24);
        $data_array[] = $this->generateSingleCompanyData("j", 10,30);
        return $data_array;
    }

    public function getCompanyDataWithProfitPricingData() {
        $data_array = [];
        $data_array[] = $this->generateSingleCompanyData("a", 1, 1, 1, .05, .05);
        $data_array[] = $this->generateSingleCompanyData("b", 2, 5, 2.5, 0.5, 2);
        $data_array[] = $this->generateSingleCompanyData("c", 3, 8, 2.666, .05, 2.1666);
        $data_array[] = $this->generateSingleCompanyData("d", 4, 9, 2.25, .05, 1.75);
        $data_array[] = $this->generateSingleCompanyData("e", 5, 10, 2, .05, 1.5);
        $data_array[] = $this->generateSingleCompanyData("f", 6, 17, 2.8333, 0.5, 2.3333);
        $data_array[] = $this->generateSingleCompanyData("g", 7, 17, 2.4285714285714, 0.5, 1.9285714285714);
        $data_array[] = $this->generateSingleCompanyData("h", 8, 20, 2.5, 0.5, 2);
        $data_array[] = $this->generateSingleCompanyData("i", 9, 24, 2.6666666666667, .05, 2.1666666666667);
        $data_array[] = $this->generateSingleCompanyData("j", 10,30, 3, 0.5, 2.5);
        return $data_array;
    }

    public function generateSingleCompanyData($company_name, $amount, $price, $price_per_unit = null, $cost_per_unit = null, $profit_per_unit = null) {
        $single_company_data = [];
        $single_company_data['company_name'] = $company_name;
        $single_company_data['amount'] = $amount;
        $single_company_data['price'] = $price;
        $single_company_data['price_per_unit'] = $price_per_unit;
        $single_company_data['cost_per_unit'] = $cost_per_unit;
        $single_company_data['profit_per_unit'] = $profit_per_unit;
        return $single_company_data;
    }

    public function testCalculateProfitForEachCompanyOffer() {
        $bid_data = $this->getRawCompanyData();
        $maximumProfitCalculator = new MaximumProfitCalculator();
        $results = $maximumProfitCalculator->calculatePricePerUnit($bid_data, self::COST_PER_UNIT_TO_PRODUCE);
        $this->assertEquals($results[0]['price_per_unit'], 1);
        $this->assertEquals($results[9]['price_per_unit'], 3);
        $this->assertEquals($results[0]['profit_per_unit'], .5);
        $this->assertEquals($results[9]['profit_per_unit'], 2.5);
    }

    public function testSortCompaniesByHighestProfit() {;        
        $maximumProfitCalculator = new MaximumProfitCalculator();
        $results = $maximumProfitCalculator->sortCompaniesByHighestProfit( $this->getCompanyDataWithProfitPricingData() );
        $this->assertEquals($results[0]['profit_per_unit'], 2.5);
    }

    public function testGetClientsToSellToWith10InCurrentInventory() {
        $maximumProfitCalculator = new MaximumProfitCalculator();
        $maximumProfitCalculator->setBidData($this->getRawCompanyData());
        $maximumProfitCalculator->setCostPerUnitToProduce(self::COST_PER_UNIT_TO_PRODUCE);
        $maximumProfitCalculator->setCurrentInventoryAmount(10);
        $results = $maximumProfitCalculator->findClientsToSellTo();
        $this->assertEquals($results[0]['company_name'], "j");
        $this->assertEquals($results[0]['profit_per_unit'], 2.5);
        $this->assertEquals(count($results),1);
    }    

    public function testGetClientsToSellToWith11InCurrentInventory() {
        $maximumProfitCalculator = new MaximumProfitCalculator();
        $maximumProfitCalculator->setBidData($this->getRawCompanyData());
        $maximumProfitCalculator->setCostPerUnitToProduce(self::COST_PER_UNIT_TO_PRODUCE);
        $maximumProfitCalculator->setCurrentInventoryAmount(11);
        $results = $maximumProfitCalculator->findClientsToSellTo();
        $this->assertEquals($results[0]['company_name'], "j");
        $this->assertEquals($results[1]['company_name'], "a");
        $this->assertEquals($results[0]['profit_per_unit'], 2.5);
        $this->assertEquals($results[1]['profit_per_unit'], .5);
        $this->assertEquals(count($results),2);
    }

    public function testGetClientsToSellToWith13InCurrentInventory() {
        $maximumProfitCalculator = new MaximumProfitCalculator();
        $maximumProfitCalculator->setBidData($this->getRawCompanyData());
        $maximumProfitCalculator->setCostPerUnitToProduce(self::COST_PER_UNIT_TO_PRODUCE);
        $maximumProfitCalculator->setCurrentInventoryAmount(13);
        $results = $maximumProfitCalculator->findClientsToSellTo();
        $this->assertEquals($results[0]['company_name'], "j");
        $this->assertEquals($results[1]['company_name'], "c");
        $this->assertEquals($results[0]['profit_per_unit'], 2.5);
        $this->assertEquals($results[1]['profit_per_unit'], 2.1666666666666665);
        $this->assertEquals(count($results),2);
    }


    public function testGetClientsToSellToWith19InCurrentInventory() {
        $maximumProfitCalculator = new MaximumProfitCalculator();
        $maximumProfitCalculator->setBidData($this->getRawCompanyData());
        $maximumProfitCalculator->setCostPerUnitToProduce(self::COST_PER_UNIT_TO_PRODUCE);
        $maximumProfitCalculator->setCurrentInventoryAmount(19);
        $results = $maximumProfitCalculator->findClientsToSellTo();
        $this->assertEquals($results[0]['company_name'], "j");
        $this->assertEquals($results[1]['company_name'], "f");
        $this->assertEquals($results[2]['company_name'], "c");
        $this->assertEquals($results[0]['profit_per_unit'], 2.5);
        $this->assertEquals($results[1]['profit_per_unit'], 2.3333333333333335);
        $this->assertEquals($results[2]['profit_per_unit'], 2.1666666666667);
        $this->assertEquals(count($results),3);
    }

}