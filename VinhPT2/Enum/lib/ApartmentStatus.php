<?php

namespace Samples\Newbie\VinhPT2\Enum\lib;

use Core\lib\Enum;
use L;

enum ApartmentStatus: int {
    use Enum;

    #[L('Chưa có người thuê')]
    case NOTRENT = 0;
    #[L('Đã có người thuê')]
    case RENTED = 1;
}
