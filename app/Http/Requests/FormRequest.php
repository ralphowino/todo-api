<?php namespace Ralphowino\Tutorials\Todo\Http\Requests;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;

class FormRequest
{
    protected $validator;
    protected $hidden = [];

    public  $request;

    function __construct()
    {
        $this->request = \App::make('request');
        $this->validate();
    }

    function validate()
    {
        $this->validator = \Validator::make($this->request->all(),$this->rules(),$this->messages());
        if($this->validator->fails())
        {
            throw new ResourceException ('Validation Failed',$this->validator->errors());
        }
    }

    function rules()
    {
        return [];
    }

    function messages()
    {
        return [];
    }

    function failed()
    {
        if(isset($this->redirectRoute))
            return $this->redirectRoute();
        if(isset($this->redirectTo))
            return $this->redirectTo();
        return $this->redirectBack();

    }

    function redirectRoute()
    {
        return \Redirect::route($this->redirectRoute)->withErrors($this->validator)->withInput($this->request->except($this->hidden));
    }


    function redirectTo()
    {
        return \Redirect::to($this->redirectTo)->withErrors($this->validator)->withInput($this->request->except($this->hidden));
    }

    function redirectBack()
    {
        return \Redirect::back()->withErrors($this->validator)->withInput($this->request->except($this->hidden));
    }

    function __call($method,$args)
    {
        return call_user_func_array([$this->request,$method],$args);
    }

}
