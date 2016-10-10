<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-10 18:20
 */
namespace Notadd\Foundation\Routing\Traits;
/**
 * Class Transactions
 * @package Notadd\Foundation\Routing\Traits
 */
trait Transactions {
    /**
     * @return void
     */
    public function commit() {
        $this->getConnection()->commit();
    }
    /**
     * @return void
     */
    protected function beginTransaction() {
        $this->getConnection()->beginTransaction();
    }
    /**
     * @return \Illuminate\Database\Connection
     */
    protected function getConnection() {
        return $this->container->make('db.connection');
    }
    /**
     * @return void
     */
    public function rollBack() {
        $this->getConnection()->rollBack();
    }
}