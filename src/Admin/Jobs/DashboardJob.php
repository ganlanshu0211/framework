<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-06 14:17
 */
namespace Notadd\Admin\Jobs;
use Notadd\Member\Models\Member;
/**
 * Class DashboardJob
 * @package Notadd\Admin\Jobs
 */
class DashboardJob {
    /**
     * @return array
     */
    public function handle() {
        return Member::find(1);
    }
}