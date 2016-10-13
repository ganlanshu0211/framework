<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 19:02
 */
namespace Notadd\Foundation\Member\Contracts;
/**
 * Interface Driver
 * @package Notadd\Foundation\Member\Contracts
 */
interface Driver {
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    public function create(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    public function delete(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    public function edit(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    public function store(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    public function update(array $data, $force = false);
}