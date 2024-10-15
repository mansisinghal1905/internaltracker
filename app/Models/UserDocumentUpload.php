<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserDocumentUpload extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [

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
    // public function getdocumentAttribute($details)
    // {
    //     if ($details != '') {
    //         return asset('public/user_documents').'/'.$details;
    //     }
    //     return asset('images/no_avatar.jpg');
    // }

     public function FetchTechnicaluser($request, $columns) {
        // Join with the user_document_uploads table
        $query = User::where('users.id', '!=', 31)  // Specify 'users.id' instead of just 'id'
            ->where('users.role', '4')
            ->where('users.type', '2')
            ->where('users.status', '!=', 2)->whereNull('users.deleted_at')
            ->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(users.created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(users.created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.first_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('users.last_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('users.created_at', 'like', '%' . $searchValue . '%');
            });
        }

        if (isset($request->status)) {
            $query->where('users.status', $request->status);
        }

        if (isset($request->order_column)) {
            $categories = $query->orderBy($columns[$request->order_column], $request->order_dir);
        } else {
            $categories = $query->orderBy('users.created_at', 'desc');
        }

        return $categories->select('users.*');
    }

    public function FetchTechnicalVendor($request, $columns) {
        // Join with the user_document_uploads table
        $query = User::where('users.id', '!=', 31)  // Specify 'users.id' instead of just 'id'
            ->where('users.type', '1')
            ->where('users.role', '4')
            ->where('users.status', '!=', 2)->whereNull('users.deleted_at')

            ->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(users.created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(users.created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('users.first_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('users.last_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('users.created_at', 'like', '%' . $searchValue . '%');
            });
        }

        if (isset($request->status)) {
            $query->where('users.status', $request->status);
        }

        if (isset($request->order_column)) {
            $categories = $query->orderBy($columns[$request->order_column], $request->order_dir);
        } else {
            $categories = $query->orderBy('users.created_at', 'desc');
        }

        return $categories->select('users.*');
    }
     public function getDocument() {

        return $this->belongsTo(User::class,'user_id','id')->where('id', '!=', 31)->where('status','!=','0');

    }
}
