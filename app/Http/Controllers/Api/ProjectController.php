<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(){
         $projects = Project::all();
         return response()->json([
            'success' => true,
            'results' => $projects
         ]);
    }

    public function show($slug){
        // recuperiamo il progetto avente un determinato slug
        $project = Project::with('types', 'technologies')->where('slug', $slug)->get();

        if ($project) {
            return response()->json([
                'success' => true,
                'result' => $projects
             ]);
        }
        return response()->json([
            'success' => false,

        ]);
       
   }
}
