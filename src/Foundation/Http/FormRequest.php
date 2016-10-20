<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 14:35
 */
namespace Notadd\Foundation\Http;
use HttpResponseException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Notadd\Foundation\Routing\Redirector;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;
/**
 * Class FormRequest
 * @package Notadd\Foundation\Http
 */
class FormRequest extends Request implements ValidatesWhenResolved {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation'
    ];
    /**
     * @var string
     */
    protected $errorBag = 'default';
    /**
     * @var string
     */
    protected $redirect;
    /**
     * @var \Notadd\Foundation\Routing\Redirector
     */
    protected $redirector;
    /**
     * @return array
     */
    public function attributes() {
        return [];
    }
    /**
     * @return \Zend\Diactoros\Response
     */
    public function forbiddenResponse() {
        return new Response('Forbidden', 403);
    }
    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator) {
        return $validator->getMessageBag()->toArray();
    }
    /**
     * @return mixed
     */
    protected function getRedirectUrl() {
        $url = $this->redirector->getUrlGenerator();
        if($this->redirect) {
            return $url->to($this->redirect);
        }
        return $url->previous();
    }
    /**
     * @return array
     */
    public function messages() {
        return [];
    }
    /**
     * @param array $errors
     * @return \Notadd\Foundation\Routing\Responses\RedirectResponse|\Zend\Diactoros\Response\JsonResponse
     */
    public function response(array $errors) {
        if($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
        return $this->redirector->to($this->getRedirectUrl())->withInput($this->except($this->dontFlash))->withErrors($errors, $this->errorBag);
    }
    /**
     * @param \Illuminate\Container\Container $container
     * @return \Notadd\Foundation\Http\FormRequest
     */
    public function setContainer(Container $container) {
        $this->container = $container;
        return $this;
    }
    /**
     * @param \Notadd\Foundation\Routing\Redirector $redirector
     * @return \Notadd\Foundation\Http\FormRequest
     */
    public function setRedirector(Redirector $redirector) {
        $this->redirector = $redirector;
        return $this;
    }
    /**
     * @return void
     */
    public function validate() {
        $instance = $this->getValidatorInstance();
        if(!$this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif(!$instance->passes()) {
            $this->failedValidation($instance);
        }
    }
    protected function getValidatorInstance() {
        $factory = $this->container->make(ValidationFactory::class);
        if(method_exists($this, 'validator')) {
            return $this->container->call([
                $this,
                'validator'
            ], compact('factory'));
        }
        return $factory->make($this->validationData(), $this->container->call([
            $this,
            'rules'
        ]), $this->messages(), $this->attributes());
    }
    protected function passesAuthorization() {
        if(method_exists($this, 'authorize')) {
            return $this->container->call([
                $this,
                'authorize'
            ]);
        }
        return false;
    }
    protected function failedAuthorization() {
        throw new HttpResponseException($this->forbiddenResponse());
    }
    protected function failedValidation(Validator $validator) {
        throw new ValidationException($validator, $this->response($this->formatErrors($validator)));
    }
    protected function validationData() {
        return $this->all();
    }
}