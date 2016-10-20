<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 12:06
 */
namespace Notadd\Foundation\Http\Traits;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Notadd\Foundation\Http\Request;
use Notadd\Foundation\Routing\UrlGenerator;
use Zend\Diactoros\Response\JsonResponse;
/**
 * Class ValidatesRequests
 * @package Notadd\Foundation\Http\Traits
 */
trait ValidatesRequests {
    /**
     * @var string
     */
    protected $validatesRequestErrorBag;
    /**
     * @param $validator
     * @param \Notadd\Foundation\Http\Request|null $request
     */
    public function validateWith($validator, Request $request = null) {
        $request = $request ?: Container::getInstance()->make('request');
        if(is_array($validator)) {
            $validator = $this->getValidationFactory()->make($request->all(), $validator);
        }
        if($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
    /**
     * @param \Notadd\Foundation\Http\Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []) {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
        if($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
    /**
     * @param $errorBag
     * @param \Notadd\Foundation\Http\Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function validateWithBag($errorBag, Request $request, array $rules, array $messages = [], array $customAttributes = []) {
        $this->withErrorBag($errorBag, function () use ($request, $rules, $messages, $customAttributes) {
            $this->validate($request, $rules, $messages, $customAttributes);
        });
    }
    /**
     * @param \Notadd\Foundation\Http\Request $request
     * @param $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwValidationException(Request $request, $validator) {
        throw new ValidationException($validator, $this->buildFailedValidationResponse($request, $this->formatValidationErrors($validator)));
    }
    /**
     * @param \Notadd\Foundation\Http\Request $request
     * @param array $errors
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    protected function buildFailedValidationResponse(Request $request, array $errors) {
        if($request->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
        return redirect()->to($this->getRedirectUrl())->withInput($request->input())->withErrors($errors, $this->errorBag());
    }
    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return mixed
     */
    protected function formatValidationErrors(Validator $validator) {
        return $validator->errors()->getMessages();
    }
    protected function getRedirectUrl() {
        return Container::getInstance()->make(UrlGenerator::class)->previous();
    }
    /**
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory() {
        return Container::getInstance()->make(Factory::class);
    }
    /**
     * @param $errorBag
     * @param callable $callback
     */
    protected function withErrorBag($errorBag, callable $callback) {
        $this->validatesRequestErrorBag = $errorBag;
        call_user_func($callback);
        $this->validatesRequestErrorBag = null;
    }
    /**
     * @return string
     */
    protected function errorBag() {
        return $this->validatesRequestErrorBag ?: 'default';
    }
}