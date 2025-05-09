<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'landing_page_id',
        'name',
        'title',
        'subtitle',
        'solutions',
        
    ];

    protected $casts = [
        'solutions' => 'array',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
