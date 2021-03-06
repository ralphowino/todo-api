<?php
namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Contracts;


/**
 * Class BaseRepository
 *
 * @package Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent
 */
interface BaseRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * @param mixed $key
     * @param bool  $fail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getByKey($key, $fail = true);

    /**
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginated($limit);

    /**
     * @param \Ralphowino\Tutorials\Todo\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($request);

    /**
     * @param mixed                                                $key
     * @param \Ralphowino\Tutorials\Todo\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($key, $request);

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function delete($key);
}