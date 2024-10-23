<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessMember extends Model
{
    use HasFactory;
    protected $table = 'business_registrations';
    protected $fillable = [
        'business_name',
        'business_license_number',
        'license_issue_date',
        'license_issue_place',
        'business_field',
        'head_office_address',
        'phone',
        'fax',
        'email',
        'branch_address',
        'organization_participation',
        'representative_full_name',
        'representative_position',
        'gender',
        'identity_card',
        'identity_card_issue_date',
        'home_address',
        'contact_phone',
        'representative_email',
        'business_license_file',
        'identity_card_front_file',
        'identity_card_back_file',
    ];
}
