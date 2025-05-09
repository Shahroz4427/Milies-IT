<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestimonialSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_title',
        'section_subtitle',
        'testimonials',
        'landing_page_id',
        'name'
    ];

    protected $casts = [
        'testimonials' => 'array',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

}
