<?php namespace Ralphowino\Tutorials\Todo\Http\Controllers\Traits;

trait SortableTrait
{
    protected $sortBy = 'recent';

    function sortableIndex($request)
    {
        $this->sort($request);
    }

    function sort($request)
    {
        if($request->has('sort'))
        {
            $this->sortBy = $request->get('sort');
        }
        $this->repository->sort($this->sortBy);
    }
}
