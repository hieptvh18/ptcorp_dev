<?php

namespace Modules\Notification\Enums;


enum CampainStatusEnum: string
{
    case DRAFT = 'DRAFT';
    case PUBLISH = 'PUBLISH';
    case ARCHIVE = 'ARCHIVE';
}
