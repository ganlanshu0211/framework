<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-19 14:05
 */
namespace Notadd\Foundation\Database;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Seeder as IlluminateSeeder;
/**
 * Class Seeder
 * @package Notadd\Foundation\Database
 */
abstract class Seeder extends IlluminateSeeder {
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;
    /**
     * Seeder constructor.
     * @param \Illuminate\Database\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection) {
        $this->connection = $connection;
    }
}