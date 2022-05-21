<?php

namespace App\Http\Controllers;

use App\Calendar\TimeTable;
use App\Models\Auditory;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Http\Response;

class ScheduleController extends Controller
{
    /**
     * Main application page. Depends on user settings it could return the list of available groups, teachers and
     * auditors or just display today's schedule.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response("Hello world");
    }

    /**
     * Show the group schedule
     *
     * @param Group $group
     * @return Response
     */
    public function group(Group $group): Response
    {
        $hours = TimeTable::getGroupEvents($group);
        return response("Group schedule");
    }

    /**
     * Show the teacher schedule
     *
     * @param Teacher $teacher
     * @return Response
     */
    public function teacher(Teacher $teacher): Response
    {
        $hours = TimeTable::getTeacherEvents($teacher);
        return response();
    }

    /**
     * Show the auditory schedule
     *
     * @param Auditory $auditory
     * @return Response
     */
    public function auditory(Auditory $auditory): Response
    {
        $hours = TimeTable::getAuditoryEvents($auditory);
        return response();
    }

}
