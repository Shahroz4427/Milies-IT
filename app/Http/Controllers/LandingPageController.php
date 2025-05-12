<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    public function show($slug)
    {
        $landingPage = LandingPage::with([
            'topBannerSection',
            'customWebDevSection',
            'finalCTASection',
            'portfolioSection',
            'testimonialSection',
            'solutionSection',
            'websiteManagementService',
            'digitalMarketingSection',
            'cmsCapabilitiesSection',
            'siteLogo',
            'siteContact',
        ])->where('slug', $slug)->firstOrFail();

        
        return view('landing', compact('landingPage'));
    }

    public function contactSubmission(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:contact_submissions,company_email',
            'phone' => 'nullable|regex:/^[0-9+\-\s()]{7,20}$/',
            'company' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'pageId' => 'required|exists:landing_pages,id' 
        ]);
    
        $submission = new ContactSubmission();
        $submission->landing_page_id = $validatedData['pageId'];
        $submission->first_name = $validatedData['firstname'];
        $submission->last_name = $validatedData['lastname'];
        $submission->company_email = $validatedData['email'];
        $submission->phone = $validatedData['phone'];
        $submission->company_name = $validatedData['company'];
        $submission->description = $validatedData['message'];
        $submission->save();
    
        return redirect()->back()->with('success', 'Your message has been sent successfully. We will get back to you soon');
    }
    
}
