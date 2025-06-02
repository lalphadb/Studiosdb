// app/Traits/LogsActivity.php
namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;
use Spatie\Activitylog\LogOptions;

trait LogsActivity
{
    use SpatieLogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} {$this->getTable()}");
    }
    
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            activity()
                ->performedOn($model)
                ->withProperties(['attributes' => $model->getAttributes()])
                ->log('created');
        });
        
        static::updated(function ($model) {
            activity()
                ->performedOn($model)
                ->withProperties([
                    'old' => $model->getOriginal(),
                    'attributes' => $model->getAttributes()
                ])
                ->log('updated');
        });
        
        static::deleted(function ($model) {
            activity()
                ->performedOn($model)
                ->log('deleted');
        });
    }
}
