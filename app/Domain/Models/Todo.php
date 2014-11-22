<?php namespace Ralphowino\Tutorials\Todo\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * Ralphowino\Tutorials\Todo\Domain\Models\Todo
 *
 * @property int      $id
 * @property string   $title
 * @property string   $summary
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 * @property Carbon   $deleted_at
 * @property Carbon   $due_at
 * @property Carbon   $completed_at
 * @property string   $status
 * @property array    $statuses
 * @method static \Ralphowino\Tutorials\Todo\Domain\Models\Todo status($statuses)
 */
class Todo extends \Eloquent
{
    use SoftDeletingTrait;

    /**
     * @var array
     */
    protected $dates = ['due_at', 'completed_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $statuses = [
        'completed' => [
            'completed_at' => 'not-null',
        ],
        'pending' => [
            'completed_at' => 'null',
            'due_at' => 'in-future',
        ],
        'overdue' => [
            'completed_at' => 'null',
            'due_at' => 'in-past',
        ],
    ];


    /**
     * @param $value
     */
    function setDueAtAttribute($value)
    {
        $this->attributes['due_at'] = date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * @param $value
     */
    function setCompletedAtAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes['completed_at'] = date('Y-m-d H:i:s', strtotime($value));
        }
    }

    /**
     * @return string
     */
    function getStatusAttribute()
    {
        return !is_null($this->completed_at) ? 'completed' : ($this->due_at > Carbon::now() ? 'pending' : 'overdue');
    }


    /**
     * @param Builder    $query
     * @param     string $statuses
     */
    function scopeStatus($query, $statuses)
    {
        $statuses = array_intersect($statuses, array_keys($this->statuses));
        $conditions = array_only($this->statuses, $statuses);
        foreach ($conditions as $status) {
            $query->orWhere(function ($query) use ($status) {

                foreach ($status as $attr => $state) {
                    switch ($state) {
                        case "not-null":
                            $query->where($attr, '!=', 'null');
                            break;
                        case "in-future":
                            $query->where($attr, '>', date('Y-m-d H:i:s'));
                            break;
                        case "in-past":
                            $query->where($attr, '<', date('Y-m-d H:i:s'));
                            break;
                        default:
                            $query->whereNull($attr);
                    }

                }
                return $query;
            });
        }
        return $query;
    }


}