<?php

namespace App\Repositories;

use App\Models\Auditory;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository
{

    /**
     * @param Group|Teacher|Auditory $subject
     * @return Collection
     */
    public function getCurrentsHours(Group|Teacher|Auditory $subject): Collection
    {
        return $subject->hours()
            ->where('date', '>=', date("Y-m-d", strtotime("2 weeks ago")))
            ->with('auditory', 'subject', 'type', 'group', 'teacher')
            ->get();
    }
}