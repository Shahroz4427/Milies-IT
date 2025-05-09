<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsCapabilitiesSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'logos',
        'bullet_points',
        'landing_page_id',
        'name'
    ];

    protected $casts = [
        'logos' => 'array',
        'bullet_points' => 'array',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

}
