<?php  namespace Ralphowino\Tutorials\Todo\Http\Transformers; 
use Ralphowino\Tutorials\Todo\Domain\Models\Todo;

class TodoTransformer extends BaseTransformer
{
    function transform(Todo $todo)
    {
        $tranformed = [
            'id' => $todo->id,
            'title' => $todo->title,
            'summary' => $todo->summary,
            'due_at' => $todo->due_at,
            'status' => $todo->status,
            'completed_at' => $todo->completed_at,
            'created_at' => $todo->created_at,
            'updated_at' => $todo->updated_at,
            'archived_at' => $todo->deleted_at,
        ];
        return parent::filter($tranformed);
    }
}