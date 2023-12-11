<?php

namespace App\Http\Controllers;

use App\Services\RadarQuery;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function __construct(private RadarQuery $rq)
    {
    }
    public function index(Request $request)
    {
        $this->authorize('use-dashboard');
        $activeTab = $request->query('tab');
        $tabParameters = [
            'activeTab' => $activeTab
        ];

        if ($activeTab == null) {
            $tabParameters['totalSkills'] = $this->rq->totalSkills();
            $tabParameters['totalUsers'] = $this->rq->totalUsers();
            $tabParameters['totalNotes'] = $this->rq->totalNotes();
            $tabParameters['totalSubjects'] = $this->rq->totalSubjects();
            $tabParameters['totalGroups'] = $this->rq->totalGroups();
            $usersByMonth = $this->rq->usersByMonth();
            $data = $usersByMonth->reduce(function ($acc, $data) {
                $date = Carbon::create($data->date);
                $fullDate = $date->format('D, M j, Y');;
                $acc["labels"][] = $fullDate;
                $acc["numbers"][] = $data->count;
                return $acc;
            }, ["labels" => [], "numbers" => []]);

            $usersChart = [
                "labels" =>  $data['labels'],
                "datasets" => [
                    [
                        "label" => 'New users',
                        "data" => $data['numbers'],
                        "backgroundColor" => 'rgba(255, 0, 255, 0.5)',
                    ]
                ]
            ];
            $tabParameters['usersChart'] = $usersChart;
        } elseif ($activeTab == 'users') {
            $tabParameters['users'] = $this->rq->usersTable();
        } elseif ($activeTab == 'subjects') {
            $tabParameters['subjects'] = $this->rq->subjectsTable();
        } elseif ($activeTab == 'groups') {
            $tabParameters['groups'] = $this->rq->groupsTable();
        } elseif ($activeTab == 'notes') {
            $tabParameters['notes'] = $this->rq->notesTable();
        }

        return view(
            'dashboard.index',
            $tabParameters
        );
    }
}
