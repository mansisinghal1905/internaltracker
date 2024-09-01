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
      
        $query = User::where('id', '!=', 1)->where('status','!=',2)->where('role','2')->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request['search']['value'] . '%');
                $q->where('last_name', 'like', '%' . $request['search']['value'] . '%');
                $q->where('role', 'like', '%' . $request['search']['value'] . '%');
                $q->where('phone_number', 'like', '%' . $request['search']['value'] . '%');
                $q->where('email', 'like', '%' . $request['search']['value'] . '%');

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

    // public function getCustomer() {
    //     return $this->belongsTo(User::class, 'customer_id')->where('role',2)->where('id', '!=', 1); 
    // }

    // public function getVendor() {
    //     return $this->belongsTo(User::class, 'vendor_id')->where('role',3)->where('id', '!=', 1); 
    // }


    
}