<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinalCTASection extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'button_text',
        'button_link',
        'landing_page_id',
    ];


    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
