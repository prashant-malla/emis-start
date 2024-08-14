<?php

namespace App\Enum;

enum VoucherTypeEnum: string
{
  case CASH = 'Cash';
  case BANK = 'Bank';
  case PURCHASE = 'Purchase';
  case JOURNAL = 'Journal';
}
