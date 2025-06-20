<?php

namespace Samples\Newbie\VinhPT2\Enum\lib;

use Core\lib\Enum;
use L;

enum FeedBackStatus: int {
    use Enum;

    #[L('Chưa xử lý')]
    case NOTDONE = 0;
    #[L('Đã xử lý')]
    case DONE = 1;

}
