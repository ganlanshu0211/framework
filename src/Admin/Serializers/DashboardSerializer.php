<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-06 14:36
 */
namespace Notadd\Admin\Serializers;
use Notadd\Foundation\Passport\Abstracts\Serializer;
/**
 * Class DashboardSerializer
 * @package Notadd\Admin\Serializers
 */
class DashboardSerializer extends Serializer {
    /**
     * @var string
     */
    protected $type = 'user';
    /**
     * @param $user
     * @return array
     */
    protected function getDefaultAttributes($user) {
        return [
            'username' => $user->getAttribute('name')
        ];
    }
}