<?php

namespace App\Http\Controllers;

use App\Services\RadarQuery;
use Illuminate\Http\Request;

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
