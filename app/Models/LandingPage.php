<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    protected $fillable = [
        'title',
        'slug'
    ];

    public static function booted()
    {
        static::creating(function ($landingPage) {
            if (empty($landingPage->slug)) {
                $landingPage->slug = Str::slug($landingPage->title);
            }
        });

        static::updating(function ($landingPage) {
            if (empty($landingPage->slug)) {
                $landingPage->slug = Str::slug($landingPage->title);
            }
        });
    }

    public function topBannerSection(): HasOne
    {
        return $this->hasOne(TopBannerSection::class);
    }

    public function customWebDevSection(): HasOne
    {
        return $this->hasOne(CustomWebDevSection::class);
    }

    public function finalCTASection(): HasOne
    {
        return $this->hasOne(FinalCTASection::class);
    }

    public function portfolioSection(): HasOne
    {
        return $this->hasOne(PortfolioSection::class);
    }

    public function testimonialSection(): HasOne
    {
        return $this->hasOne(TestimonialSection::class);
    }

    public function solutionSection(): HasOne
    {
        return $this->hasOne(SolutionSection::class);
    }

    public function websiteManagementService(): HasOne
    {
        return $this->hasOne(WebsiteManagementService::class);
    }

    public function digitalMarketingSection(): HasOne
    {
        return $this->hasOne(DigitalMarketingSection::class);
    }

    public function cmsCapabilitiesSection(): HasOne
    {
        return $this->hasOne(CmsCapabilitiesSection::class);
    }

    public function contactSubmissions(): HasMany
    {
        return $this->hasMany(ContactSubmission::class);
    }

    public function siteLogo(): HasOne
    {
        return $this->hasOne(SiteLogo::class);
    }
    
    public function siteContact(): HasOne
    {
        return $this->hasOne(SiteContact::class);
    }
}