<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalMarketingSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'services',
        'landing_page_id',
        'name'
    ];

    protected $casts = [
        'services' => 'array',
    ];


    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
