<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hour extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'time', 'date', 'group_id', 'auditory_id', 'subject_id', 'type_id', 'teacher_id'];

    public $timestamps = false;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
    public function auditory(): BelongsTo
    {
        return $this->belongsTo(Auditory::class);
    }
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function compareTo(Hour $hour): bool
    {
        return $this->time == $hour->time
            and $this->date == $hour->date
            and $this->group->is($hour->group)
            and $this->teacher->is($hour->teacher)
            and $this->subject->is($hour->subject)
            and $this->type->is($hour->type);
    }

}
