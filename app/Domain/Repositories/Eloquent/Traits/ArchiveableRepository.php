<?php namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits;

/**
 * Trait ArchiveableRepository
 *
 * @property \Illuminate\Database\Eloquent\SoftDeletingTrait $query
 * @package Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits
 */
trait ArchiveableRepository
{

    /**
     * @param $include
     */
    function getArchived($include)
    {
        if ($include == 'only')
            $this->query = $this->query->onlyTrashed();
        $this->query = $this->query->withTrashed();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function archive($id)
    {
        $model = $this->getByKey($id);
        $model->delete();
        return $model;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function restore($id)
    {
        $this->query = $this->query->onlyTrashed();
        $model = $this->getByKey($id);
        $model->restore();
        return $model;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        $this->query = $this->query->withTrashed();
        $model = $this->getByKey($id);
        return $model->forceDelete();
    }
}
