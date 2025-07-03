<?php

namespace Samples\Newbie\VinhPT2\Enum\lib;

use Core\lib\Enum;
use L;

enum FeeStatus: int {
    use Enum;

    #[L('Đã đóng đúng hạn')]
    case PAIDONTIME = 0;
    #[L('Không đóng đúng hạn')]
    case EXPIRED = 1;
    #[L('Chưa đóng')]
    case NOTPAID = 2;
    #[L('Cần đóng')]
    case NEEDPAID = 3;

}
