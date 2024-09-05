<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class VendorPaymentHistory extends Authenticatable
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

    public function fetchVendorPayment1($request, $columns1) {
      
        $query = VendorPaymentHistory::where("vendor_payment_id",$request->vendor_payment_id)
                ->orderBy('id', 'desc');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        
        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('amount', 'like', '%' . $searchValue . '%')
                  ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                  ->orWhere('payment_purpose', 'like', '%' . $searchValue . '%');

            });
        }
       

        if (isset($request->order_column)) {
            $categories = $query->orderBy($columns1[$request->order_column], $request->order_dir);
        } else {
            $categories = $query->orderBy('created_at', 'desc');
        }
        return $categories;
    }

    public function getVendor() {

        return $this->belongsTo(User::class,'vendor_id','id')->where('id', '!=', 31)->where('status','!=','0'); 

    }
    public function getvendorpayment() {

        return $this->belongsTo(VendorPayment::class,'vendor_payment_id','id'); 

    }
}
