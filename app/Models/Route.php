<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
class Route extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
       
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function fetchRoute($request, $columns) {
      
        $query = User::where('id', '!=', 31)->where('status','!=',2)->where('type','2')->where('role','3')->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];

            $query->where(function ($q) use ($searchValue) {
                $q->where('first_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('email', 'like', '%' . $searchValue . '%')
                  ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            });
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }
        if (isset($request->order_column)) {
            $categories = $query->orderBy($columns[$request->order_column], $request->order_dir);
        } else {
            $categories = $query->orderBy('created_at', 'desc');
        }
        return $categories;
    }

    public function fetchvendor($request, $columns) {
      
        $query = User::where('id', '!=', 31)->where('status','!=',2)->where('type','1')->where('role','3')->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        
        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];

            $query->where(function ($q) use ($searchValue) {
                $q->where('first_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('email', 'like', '%' . $searchValue . '%')
                  ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            });
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }
        if (isset($request->order_column)) {
            $categories = $query->orderBy($columns[$request->order_column], $request->order_dir);
        } else {
            $categories = $query->orderBy('created_at', 'desc');
        }
        return $categories;
    }

    


    
}
