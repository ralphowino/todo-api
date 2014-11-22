<?php  namespace Ralphowino\Tutorials\Todo\Http\Transformers; 
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    function filter($transformed)
    {
        $request = \App::make('request');
        if($request->has('fields'))
        {
            $fields = explode(',',$request->get('fields'));
            $fields = array_intersect($fields, array_keys($transformed));
            $transformed = array_only($transformed,$fields);
        }
        return $transformed;
    }
}