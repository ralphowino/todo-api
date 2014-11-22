<?php namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits;

/**
 * Class SearchableRepository
 *
 * @property  \Illuminate\Database\Eloquent\Builder query
 * @package Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits
 */
trait SearchableRepository
{
    /**
     * @return array
     */
    abstract function getSearchable();

    /**
     * @param $q
     */
    function search($q)
    {
        $fields = $this->getSearchable();

        $this->query = $this->query->where(function ($query) use ($q, $fields) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', '%' . $q . '%');
            }
            return $query;
        });
    }

}
