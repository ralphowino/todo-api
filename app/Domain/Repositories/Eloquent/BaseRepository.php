<?php namespace Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent;


/**
 * Class BaseRepository
 *
 * @property  \Illuminate\Database\Eloquent\Builder query
 * @property  Array fields
 * @package Ralphowino\Tutorials\Todo\Domain\Repositories\Eloquent
 */
abstract class BaseRepository implements \Ralphowino\Tutorials\Todo\Domain\Repositories\Contracts\BaseRepository
{
    

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQuery()
    {
        if(!isset($this->query))
        {
            $this->query = $this->model;
        }
        return $this->query;
    }
    
    /**
     * @return array
     */
    protected abstract function getFields();

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->query->get();
    }

    /**
     * @param mixed $key
     * @param bool $fail
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getByKey($key, $fail = true)
    {
        if($fail)
            return $this->query->findOrFail($key);
        return $this->query->find($key);
    }

    /**
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginated($limit)
    {
        return $this->query->paginate($limit);
    }

    /**
     * @param \Ralphowino\Tutorials\Todo\Http\Requests\FormRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($request)
    {
        foreach ($request->only($this->fields) as $attr => $value)
        {
            $this->model->$attr = $value;
		}
        $this->model->save();
        return $this->model;
    }

    /**
     * @param mixed $key
     * @param \Ralphowino\Tutorials\Todo\Http\Requests\FormRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($key,$request)
    {
        $model = $this->getByKey($key);
        $fields = array_filter($request->only($this->fields));
        foreach ($fields as $attr => $value)
        {
            $model->$attr = $value;
		}
        $model->save();
        return $model;
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function delete($key)
    {
        $model = $this->getByKey($key);
        return $model->delete();
    }

    public function __get($attr)
    {
        $getter = 'get'.ucfirst($attr);
        if(method_exists($this,$getter))
        {
            return $this->$getter();
        }
        return $this->$attr;
    }
}