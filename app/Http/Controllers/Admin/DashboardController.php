<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Ticket;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_user =User::where("role",'!=',"1")->where("status","!=","0")->count();
        $total_task =Task::where("status","!=","0")->count();
        $total_ticket =Ticket::where("status","!=","0")->count();

        return view('admin.index',compact('total_user','total_task','total_ticket'));

    }
}
