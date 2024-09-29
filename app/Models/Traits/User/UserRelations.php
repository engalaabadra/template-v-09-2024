<?php
namespace App\Models\Traits\User;
use App\Models\File;
use Modules\Profile\Entities\Profile;
use Modules\Wallet\Entities\Wallet;
use Modules\Review\Entities\Review;
use Modules\Specialty\Entities\Specialty;
use Modules\Favorite\Entities\Favorite;
use Modules\Reservation\Entities\Reservation;
use Modules\Appointment\Entities\Appointment;
use Modules\Chat\Entities\Chat;
use Modules\Duration\Entities\Duration;
use Modules\Time\Entities\Time;
use Modules\Day\Entities\Day;
use Modules\Geocode\Entities\Country;

trait UserRelations{
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function profile() {
        return $this->hasOne(Profile::class);
    }
    public function reviewsUser(){
        return $this->hasMany(Review::class,'user_id');
    }
    public function favoritesUser(){
        return $this->hasMany(Favorite::class,'user_id');
    }

    public function chatClients(){
        return $this->hasMany(Chat::class,'client_id');
    }

    public function chatUsers(){
        return $this->hasMany(Chat::class,'user_id');
    }

    public function wallet(){
        return $this->hasOne(Wallet::class,'user_id');
    }
}
