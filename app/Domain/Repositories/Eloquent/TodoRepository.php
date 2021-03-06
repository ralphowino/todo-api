<?php  namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent; 

use Ralphowino\Tutorials\Todo\Domain\Models\Todo;
use Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits\ArchiveableRepository;
use Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits\FilterableRepository;
use Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits\SearchableRepository;
use Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent\Traits\SortableRepository;

class TodoRepository extends BaseRepository implements \Ralphowino\Tutorials\Todo\Domain\Repositories\Contracts\TodoRepository
{
    use ArchiveableRepository, SearchableRepository, FilterableRepository, SortableRepository;
    function __construct(Todo $model)
    {
        $this->model = $model;
    }

    function getFields()
    {
        return ['title','summary','due_at','completed_at'];
    }

    function getFilterable()
    {
        return [
            'id',
            'title',
            'status' => [
                'type' => 'scope'
            ]
        ];
    }

    function getSearchable()
    {
        return [
            'title',
            'summary'
        ];
    }

    function getSortable()
    {
        return [
            'id',
            'title',
            'due_at',
            'completed_at',
            'created_at',
            'updated_at',
            'archived_at' => [
                'type' => 'field',
                'field' => 'deleted_at',
            ],
        ];
    }



}