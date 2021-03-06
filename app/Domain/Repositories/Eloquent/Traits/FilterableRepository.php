<?php namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits;

trait FilterableRepository
{
    private $request;

    abstract function getFilterable();

    function filter($request)
    {
        $this->request = $request;
        foreach($this->getFilterable() as $key => $field)
        {
            $filter = 'filter'.ucfirst(gettype($field));
            $this->$filter($key,$field);
        }
    }

    protected function filterString($key,$field)
    {
        if($this->request->has($field))
        {
            $value = explode(',',$this->request->get($field));
            $this->query = $this->query->whereIn($field,$value);
        }
    }

    protected function filterArray($field,$mapping)
    {
        if($this->request->has($field))
        {
            $filter = 'filter'.ucfirst($mapping['type']);
            $this->$filter($field,$mapping);
        }
    }

    protected function filterScope($field,$mapping)
    {
        $value = explode(',',$this->request->get($field));
        $this->query = $this->query->$field($value);
    }

}
