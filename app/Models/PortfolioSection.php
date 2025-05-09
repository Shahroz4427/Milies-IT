<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PortfolioSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_title',
        'section_description',
        'portfolio_items',
        'button_text',
        'button_link',
        'landing_page_id',
        'name'
    ];

    protected $casts = [
        'portfolio_items' => 'array', 
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }

}
