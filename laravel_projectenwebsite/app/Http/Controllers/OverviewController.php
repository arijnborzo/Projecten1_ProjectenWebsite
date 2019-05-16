<?php

namespace App\Http\Controllers;

use Auth;
use App\Group;
use App\Project;
use App\User;
use App\Student;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class OverviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
     {
         $this->middleware('auth');
         //$this->middleware('belbin');
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $user = Auth::user();
      $year = date("Y"); //-1
      $archief = false;
      $projects = Project::join('groups', 'projects.id', '=', 'groups.project_id')
          ->join('students', 'students.group_id','=', 'groups.id')
          ->join('users', 'users.id', '=', 'students.id' )
          ->select('projects.*','users.name', 'users.surname', 'students.group_id')
          ->whereYear('projects.created_at', $year)
          ->orderBy('group_id', 'ASC')
          ->get();
//      echo $projects;
      return view('overzicht', [
        'projects' => $projects,
        'user' => $user,
          'archief' => $archief

      ]);

    }
    public function archive()
    {
      $user = Auth::user();
      $year = date("Y")-1;
      $archief = true;
      $projects = Project::join('groups', 'projects.id', '=', 'groups.project_id')
          ->join('students', 'students.group_id','=', 'groups.id')
          ->join('users', 'users.id', '=', 'students.id' )
          ->select('projects.*','users.name', 'users.surname', 'students.group_id', 'projects.created_at')
          ->whereYear('projects.created_at', '!=', $year)
          ->orderBy('group_id', 'ASC')
          ->get();
      //echo $projects;
      return view('overzicht', [
        'projects' => $projects,
        'archief' => $archief,
        'user' => $user
      ]);
    }
    public function detail($id)
    {
      $user = Auth::user();

//      $usergroupid = Student::where('id', $user.id)->value('group_id');
      $projectgroupid = Group::where('project_id', $id)->value('id');
        $project = Project::where('id', $id) ->get();
        echo $user;
//      if ($usergroupid == $id) {
//        //user belongs to group of projects
//        $belongstoproject = TRUE;
//      }
//      else {
//        $belongstoproject = FALSE;
//      }
      return view('detail',[
        'project' => $project,
        'user' => $user
//        'belongstoproject' => $belongstoproject
      ]);
    }

    public function students()
    {
      $user = Auth::user();
      $students = User::rightJoin('students', 'users.id', '=', 'students.id')
            ->rightJoin('projects', 'students.group_id', '=', 'projects.id')
            ->select('students.group_id','users.name', 'users.surname', 'projects.title as projectvoorstel', 'students.belbintype as belbin')
            ->get();
      //echo $students;
      return view('students', [
          'students' => $students,
             'user' => $user
            ]
        );
    }
}
