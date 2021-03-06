<?php namespace Ralphowino\Tutorials\Todo\Http\Controllers;

use Ralphowino\Tutorials\Todo\Domain\Repositories\Contracts\TodoRepository;
use Ralphowino\Tutorials\Todo\Http\Controllers\Traits\ArchiveableTrait;
use Ralphowino\Tutorials\Todo\Http\Controllers\Traits\FilterableTrait;
use Ralphowino\Tutorials\Todo\Http\Controllers\Traits\SearchableTrait;
use Ralphowino\Tutorials\Todo\Http\Controllers\Traits\SortableTrait;
use Ralphowino\Tutorials\Todo\Http\Transformers\TodoTransformer;


class TodosController extends BaseController
{
	use ArchiveableTrait, SearchableTrait, FilterableTrait, SortableTrait;

	function __construct(TodoRepository $repository, TodoTransformer $transformer)
	{
		$this->repository = $repository;
		$this->transformer = $transformer;
		parent::__construct();
	}

	function getCreateRequest()
	{
		return \App::make('Ralphowino\Tutorials\Todo\Http\Requests\CreateTodoRequest');
	}

	function getUpdateRequest()
	{
		return \App::make('Ralphowino\Tutorials\Todo\Http\Requests\UpdateTodoRequest');
	}
}
