<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\MoneyGained;
use App\Nova\Metrics\NewOrders;
use App\Nova\Metrics\OrdersPerDay;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new NewOrders,
            new MoneyGained,
            new OrdersPerDay
        ];
    }


}
