<?php namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits;

/**
 * Class SortableRepository
 *
 * @property  \Illuminate\Database\Eloquent\Builder query
 * @package Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits
 */
trait SortableRepository
{
    /**
     * @return array
     */
    abstract function getSortable();

    /**
     * @param $order
     */
    function sort($order)
    {
        $sortable = $this->getSortable();
        $fields = explode(',', $order);
        foreach ($fields as $field) {
            $reverse = starts_with($field, '-');
            if($reverse)
            {
                $field = substr($field,1);
            }
            if (in_array($field, $sortable)) {
                $this->sortByField($field, $reverse);
            }
            if (isset($sortable[$field])) {
                $this->sortComplex($field, $sortable[$field],$reverse);
            }
        }
    }

    protected function sortByField($field, $reverse = false)
    {
        $direction = $reverse ? 'DESC' : 'ASC';
        $this->query = $this->query->orderBy($field, $direction);
    }

    protected function sortComplex($field, $details, $reverse = false)
    {
        if (isset($details['type'])) {
            $method = 'sortComplex' . studly_case($details['type']);
            $this->$method($field,$details ,$reverse);
        }
    }

    protected function sortComplexField($field,$details, $reverse)
    {
        if(isset($details['direction']))
        {
            $direction = $details['direction'];
            if($reverse)
            {
                $direction = $direction == 'ASC' ? 'DESC' : 'ASC';
            }
        }

        if(isset($details['field']))
        {
            $field = $details['field'];
        }

        $this->query = $this->query->orderBy($field, $direction);
    }

}
