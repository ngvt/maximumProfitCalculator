<?php

class MaximumProfitCalculator
{

    private $bid_data;
    private $cost_per_unit_to_produce;
    private $current_inventory_amount;

    public function setBidData($bid_data){
        $this->bid_data = $bid_data;
    }    

    public function setCostPerUnitToProduce($cost_per_unit_to_produce){
        $this->cost_per_unit_to_produce = $cost_per_unit_to_produce;
    }    

    public function setCurrentInventoryAmount($current_inventory_amount){
        $this->current_inventory_amount = $current_inventory_amount;
    }

    public function calculatePricePerUnit($bid_data, $cost_per_unit_to_produce) {
        foreach ($bid_data as &$bid) {
            $price_per_unit = $bid['price'] / $bid['amount'];
            $profit_per_unit = $price_per_unit - $cost_per_unit_to_produce;
            $bid['price_per_unit'] = $price_per_unit;
            $bid['cost_per_unit'] = $cost_per_unit_to_produce;
            $bid['profit_per_unit'] = $profit_per_unit;
        }
        return $bid_data;
    }   

    public function sortCompaniesByHighestProfit($bid_data){
        usort($bid_data, array($this, "sortByHighestProfit")) ;
        return $bid_data;
    }

    public function prepareBidData(){
        $bid_data_with_profit_info = $this->calculatePricePerUnit($this->bid_data, $this->cost_per_unit_to_produce);
        $bid_data_sorted_by_highest_profit = $this->sortCompaniesByHighestProfit($bid_data_with_profit_info);
        return $bid_data_sorted_by_highest_profit;
    }

    public function findClientsToSellTo() {
        $bid_data = $this->prepareBidData();
        $inventory_amount = $this->current_inventory_amount;

        $clients_to_sell_to = [];
        foreach ($bid_data as $bid) {
            if ($bid['amount'] <= $inventory_amount){
                array_push($clients_to_sell_to, $bid);
                $inventory_amount = $inventory_amount - $bid['amount'];
            }
        }
        return $clients_to_sell_to;
    }

    function sortByHighestProfit($a, $b)
    {   
        return $a['profit_per_unit'] < $b['profit_per_unit'];
    }

}