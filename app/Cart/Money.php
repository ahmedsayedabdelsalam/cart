<?php

namespace App\Cart;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;
use NumberFormatter;

class Money
{
    public $money;

    public function __construct(int $value)
    {
        $this->money = BaseMoney::GBP($value);
    }

    public function formatted()
    {
        return (new IntlMoneyFormatter(
            new NumberFormatter('en_GB', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        ))->format($this->money);
    }

    public function getAmount()
    {
        return $this->money->getAmount();
    }
}
