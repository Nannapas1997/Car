<?php

namespace App\Models;

use App\Models\User;
use App\Models\SaveRepairCost;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarReceive extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'choose_garage',
        'job_number',
        'job_number_new',
        'receive_date',
        'timex',
        'customer',
        'repairman',
        'tel_number',
        'pickup_date',
        'vehicle_registration',
        'brand',
        'model',
        'car_type',
        'mile_number',
        'repair_code',
        'options',
        'insu_company_name',
        'policy_number',
        'noti_number',
        'claim_number',
        'park_type',
        'car_park',
        'content',
        'spare_tire',
        'jack_handle',
        'boxset',
        'batteries',
        'cigarette_lighter',
        'radio',
        'floor_mat',
        'spare_removal',
        'fire_extinguisher',
        'spining_wheel',
        'other',
        'group_checkbox',
        'group_document',
        'real_claim',
        'copy_claim',
        'copy_driver_license',
        'copy_vehicle_regis',
        'copy_policy',
        'power_of_attorney',
        'copy_of_director_id_card',
        'copy_of_person',
        'account_book',
        'atm_card',
        'customer_document',
        'real_claim_document',
        'copy_policy_document',
        'copy_claim_document',
        'power_of_attorney_document',
        'copy_driver_license_document',
        'copy_of_director_id_card_document',
        'copy_vehicle_regis_document',
        'copy_of_person_document',
        'account_book_document',
        'atm_card_document',
        'other_document',
        'group_car',
        'front',
        'left',
        'right',
        'back',
        'inside_left',
        'inside_right',
        'inside_truck',
        'etc',
        'addressee',
        'product_id',
        'options-car',
        'car_year',
        'car_accident',
        'car_accident_choose',
    ];
    // turn off both
    public $timestamps = false;

    // turn off only updated_at
    const UPDATED_AT = null;
    protected $primaryKey = 'id';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('real-claim');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function carreceiveItems():HasMany
    {
        return $this->hasMany(CarReceiveItem::class);
    }
}

