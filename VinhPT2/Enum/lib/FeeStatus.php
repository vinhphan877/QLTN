<?php

namespace Samples\Newbie\VinhPT2\Enum\lib;

use Core\lib\Enum;
use L;

enum FeeStatus: int {
    use Enum;

    #[L('Đã trả')]
    case AVAIABLE = 0;
    #[L('Chưa trả')]
    case NOTAVAIABLE = 1;
    #[L('Quá hạn')]
    case EXPIRED = 2;

}
