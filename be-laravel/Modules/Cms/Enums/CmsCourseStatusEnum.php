<?php

namespace Modules\Cms\Enums;

enum CmsCourseStatusEnum: string
{
    case DRAFT = 'DRAFT';
    case PUBLISH = 'PUBLISH';
    case UNPUBLISH = 'UNPUBLISH';
    case PRIVATE = 'PRIVATE';
}
