<?php  namespace Ralphowino\Tutorials\Todo\Http\Requests; 
class CreateTodoRequest extends FormRequest
{

    function rules()
    {
        return [
            'title' => 'required'
        ];
    }

}