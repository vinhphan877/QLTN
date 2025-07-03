<?php

namespace Samples\Newbie\VinhPT2\Enum\lib;

use Core\lib\Enum;
use L;

enum FeeTypeStatus: int {
    use Enum;

    #[L('Còn hiệu lực')]
    case AVAILABLE = 0;
    #[L('Không còn hiệu lực')]
    case NOTAVAIABLE = 1;
}
