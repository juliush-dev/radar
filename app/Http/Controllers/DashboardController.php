<?php

namespace App\Http\Controllers;

use App\Services\RadarQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory;

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
            $tabParameters['totalTopics'] = $this->rq->totalTopics();
            $tabParameters['totalLearningMaterials'] = $this->rq->totalLearningMaterials();
            $usersByMonth = \App\Models\User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
            $data = $usersByMonth->reduce(function ($acc, $data) {
                $date = Carbon::create($data->date);
                $fullDate = $date->format('D, M j, Y');;
                $acc["labels"][] = $fullDate;
                $acc["numbers"][] = $data->count;
                return $acc;
            }, ["labels" => [], "numbers" => []]);

            $faker = Factory::create();
            $fakeUsersNumbers = [];
            for ($i = 1; $i <= 20; $i++) {
                // get a random digit, but always a new one, to avoid duplicates
                $fakeUsersNumbers[] = $faker->randomDigit();
            }
            $fakeDaysDates = []; // Initialize an empty array to store the formatted dates

            // Generate 11 created_at dates before today
            for ($i = 1; $i <= 20; $i++) {
                $date = $faker->dateTimeBetween('-30 days', 'now'); // Change the date range as needed
                $formattedDate = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'))
                    ->subDay($i) // Subtract $i days from each date
                    ->format('D, M j, Y'); // Format the date with day and month abbreviation
                $fakeDaysDates[] = $formattedDate; // Store each formatted date in the array
            }
            $usersChart = [
                "labels" => array_merge($fakeDaysDates, $data['labels']),
                "datasets" => [
                    [
                        "label" => 'New users',
                        "data" =>
                        array_merge($fakeUsersNumbers, $data['numbers']),
                        "backgroundColor" => 'rgba(255, 0, 255, 0.5)',
                    ]
                ]
            ];
            $tabParameters['usersChart'] = $usersChart;
        } elseif ($activeTab == 'users') {
            $tabParameters['users'] = $this->rq->usersTable();
        } elseif ($activeTab == 'topics') {
            $tabParameters['topics'] = $this->rq->topicsTable();
        } elseif ($activeTab == 'learning-materials') {
            $tabParameters['lms'] = $this->rq->learningMaterialsTable();
        }

        return view(
            'dashboard.index',
            $tabParameters
        );
    }
}
