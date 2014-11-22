<?php namespace Ralphowino\Tutorials\Todo\Http\Controllers\Traits;

trait ExtendableTrait
{
    function callExtensions($suffix, $request)
    {
        $suffix = ucfirst($suffix);
        $methods = array_filter(get_class_methods($this), function($method)use($suffix){
            return ends_with($method,$suffix);
        });
        foreach($methods as $method)
        {
            $this->$method($request);
        }
    }
}
