<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

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

    public function fetchTask($request, $columns) {
      
        $query = Task::where('status','!=',2)->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

       
        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];

            $query->where(function ($q) use ($searchValue) {
                $q->where('company_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('am_name', 'like', '%' . $searchValue . '%');
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

    public function getUser() {
        return $this->belongsTo(User::class, 'user_id')->where('type',2)->where('id', '!=', 31); 
    }

    public function getVendor() {
        return $this->belongsTo(User::class, 'vendor_id')->where('type',1)->where('id', '!=', 31); 
    }
    public function getCountry() {
        return $this->belongsTo(Country::class, 'register_country_id','id')->where("status","active"); 
    }

    
}
