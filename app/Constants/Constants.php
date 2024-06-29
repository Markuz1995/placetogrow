<?php

namespace App\Constants;

class Constants
{
    const RECORDS_PER_PAGE = 10;

    const MICROSITE_TYPES = [
        ['id' => 'invoice', 'name' => 'Invoice'],
        ['id' => 'subscription', 'name' => 'Subscription'],
        ['id' => 'donation', 'name' => 'Donation'],
    ];

    const MICROSITE_CURRENCY = [
        ['id' => 'COP', 'name' => 'COP'],
        ['id' => 'USD', 'name' => 'USD'],
    ];
}
