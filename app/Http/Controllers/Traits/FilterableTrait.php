<?php namespace Ralphowino\Tutorials\Todo\Http\Controllers\Traits;

trait FilterableTrait
{

    function filterableIndex($request)
    {
        $this->filter($request);
    }

    function filter($request)
    {
        $this->repository->filter($request);
    }
}
