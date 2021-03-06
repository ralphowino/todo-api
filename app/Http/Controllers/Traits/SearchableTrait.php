<?php namespace Ralphowino\Tutorials\Todo\Http\Controllers\Traits;

trait SearchableTrait
{

    function searchableIndex($request)
    {
        $this->search($request);
    }

    function search($request)
    {
        if($request->has('q'))
        {
            $this->repository->search($request->get('q'));
        }
    }
}
