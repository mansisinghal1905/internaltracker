<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fetchUser($request, $columns) {
      
        $query = User::where('id', '!=', 1)->where('status','!=',2)->orderBy('id', 'desc');

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

   

    public function getAvatarAttribute($details)
    {
        if ($details != '') {
            return asset('public/profileimage').'/'.$details;
        }
        return asset('images/no_avatar.jpg');
    } 
    public function getimageAttribute($details)
    {
        if ($details != '') {
            return asset('public/img/profileimage').'/'.$details;
        }
        return asset('images/no_avatar.jpg');
    } 
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tasksAsVendor()
    {
        return $this->hasMany(Task::class, 'vendor_id');
    }

    public function customers()
    {
        return $this->hasManyThrough(
            User::class,       // Target model (Customer)
            Task::class,       // Intermediate model (Task)
            'vendor_id',       // Foreign key on Task model (vendor_id)
            'id',              // Foreign key on User model (customer_id)
            'id',              // Local key on User model (vendor_id)
            'user_id'      // Local key on Task model (customer_id)
        )->where('role', '2');
    }

    public function getDocument()
    {
        return $this->hasMany(UserDocumentUpload::class, 'user_id');
    }
    

   
    
}
