<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomWebDevSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'landing_page_id',
        'section_heading',
        'subheading',
        'services',
    ];

    protected $casts = [
        'services' => 'array',
    ];


    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
