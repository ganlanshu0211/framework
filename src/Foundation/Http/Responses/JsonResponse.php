<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-29 17:56
 */
namespace Notadd\Foundation\Http\Responses;
use Tobscure\JsonApi\Document;
use Zend\Diactoros\Response\JsonResponse as DiactorosJsonResponse;
/**
 * Class JsonResponse
 * @package Notadd\Foundation\Http\Responses
 */
class JsonResponse extends DiactorosJsonResponse {
    /**
     * JsonResponse constructor.
     * @param \Tobscure\JsonApi\Document $document
     * @param int $status
     * @param array $headers
     * @param int $encodingOptions
     */
    public function __construct(Document $document, $status = 200, array $headers = [], $encodingOptions = 15) {
        $headers['content-type'] = 'application/vnd.api+json';
        parent::__construct($document->jsonSerialize(), $status, $headers, $encodingOptions);
    }
}