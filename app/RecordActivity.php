<?php
namespace App;


trait RecordActivity
{

    // automatically run this function when we call this trait
    // convention bootFilename
    // special function
    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
        static::deleting(function($model){
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        // subject_id and subject type created automatically
        $this->activity()->create(
            [
                'user_id' => auth()->id(),
                'type' => $this->getActivityType($event),
            ]
        );
    }

    public function activity()
    {
        // Polymorphism Relation means that Activity could have thread activity and replies activity and ....
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }
}