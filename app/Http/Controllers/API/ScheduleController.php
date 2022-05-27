<?php

namespace App\Http\Controllers\API;

use App\Calendar\TimeTable;
use App\Http\Controllers\Controller;
use App\Models\Auditory;
use App\Models\Group;
use App\Models\Teacher;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use function response;

class ScheduleController extends Controller
{
    private ScheduleRepository $repository;

    public function __construct(ScheduleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the group schedule
     *
     * @param Group $group
     * @return JsonResponse
     */
    public function group(Group $group): JsonResponse
    {
        return response()->json($this->repository->getCurrentsHours($group));
    }

    /**
     * Show the teacher schedule
     *
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function teacher(Teacher $teacher): JsonResponse
    {
        return response()->json($this->repository->getCurrentsHours($teacher));
    }

    /**
     * Show the auditory schedule
     *
     * @param Auditory $auditory
     * @return JsonResponse
     */
    public function auditory(Auditory $auditory): JsonResponse
    {
        return response()->json($this->repository->getCurrentsHours($auditory));
    }

}
