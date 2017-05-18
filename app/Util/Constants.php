<?php

namespace App\Util;

class Constants
{
    const RULE_TYPE_SEQUENTIAL_REQUIRED = 0;
    const RULE_TYPE_SEQUENTIAL_COMBO = 1;

    const TIMEFRAME_EC_TOTAL = 27.5;//TODO switch to timetable

    const USER_ROLE_STUDENT = 0;
    const USER_ROLE_TEACHER = 1;
    const USER_ROLE_ADMIN = 2;

    const COMPETENCY_STATUS_TODO = 0;
    const COMPETENCY_STATUS_DOING = 1;
    const COMPETENCY_STATUS_DONE = 2;
    const COMPETENCY_STATUS_HALF_DOING = 3;
    const COMPETENCY_STATUS_HALF_DONE = 4;

    const COMPETENCY_ALGORITHIM_ALLOWED_FALSE = 0;
    const COMPETENCY_ALGORITHIM_ALLOWED_TRUE = 1;
}//end class
