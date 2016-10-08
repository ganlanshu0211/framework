<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-06 14:30
 */
namespace Notadd\Foundation\Passport\Abstracts;
use Tobscure\JsonApi\AbstractSerializer as AbstractTobscureSerializer;
/**
 * Class AbstractSerializer
 * @package Notadd\Foundation\Passport\Abstracts
 */
abstract class AbstractSerializer extends AbstractTobscureSerializer {
    /**
     * @param array|object $model
     * @param array|null $fields
     * @return array
     */
    public function getAttributes($model, array $fields = null) {
        if(!is_object($model) && !is_array($model)) {
            return [];
        }
        $attributes = $this->getDefaultAttributes($model);
        return $attributes;
    }
    /**
     * @param array|object $model
     * @return array
     */
    abstract protected function getDefaultAttributes($model);
}