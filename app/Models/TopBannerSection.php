<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TopBannerSection extends Model
{
    use HasFactory;

    // Specify the fillable fields
    protected $fillable = [
        'landing_page_id',
        'headline', 
        'highlights', 
        'testimonial_image', 
        'trusted_logos', 
        'hero_background_image', 
    ];

    protected $casts = [
        'highlights' => 'array',
        'trusted_logos' => 'array',
        'quote_form_fields_config' => 'array',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
