<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
        <title>{{ $landingPage->title }}</title>
    </head>

    <body>
        <header class="sticky-top bg-white shadow-sm py-3">
            <div class="container d-flex justify-content-between align-items-center">
                <a href="#" class="d-flex align-items-center">
                    <img
                        src="{{ $landingPage->siteLogo && $landingPage->siteLogo->logo
                        ? asset('storage/'.$landingPage->siteLogo->logo)
                        : 'https://dummyimage.com/150x40/cccccc/000000&text=150x40' }}"
                        alt="Logo"
                        class="img-fluid"
                        style="height: 40px;"
                    />
                </a>
                <div class="d-flex align-items-center">
                    <i class="bi bi-telephone-fill me-2 text-dark"></i>
                    <a href="tel:{{ $landingPage->siteContact && $landingPage->siteContact->contact ? $landingPage->siteContact->contact : '123-456-7890' }}" class="text-dark me-4 text-decoration-none fw-bold">
                        {{ $landingPage->siteContact && $landingPage->siteContact->contact ? $landingPage->siteContact->contact : '123-456-7890' }}
                    </a>
                </div>
            </div>
        </header>
        <main>
            <section
                id="custom-website-dev-hero"
                class="info-block-v2 position-relative px-4 py-8 py-md-12 py-xl-16"
                style="background-repeat: no-repeat; background-position: center; background-size: cover; background-image: url('{{ $landingPage->topBannerSection && $landingPage->topBannerSection->hero_background_image ? asset('storage/' . $landingPage->topBannerSection->hero_background_image) : 'https://dummyimage.com/1920x1080/333333/ffffff&text=1920x1080' }}'); padding: 7%;"
            >
                <div class="container mx-auto z-3 position-relative">
                    <div class="row mt-24 align-items-stretch justify-content-center w-100 mx-auto">
                        <div class="col-12 col-lg-6 mt-8 mt-lg-0 text-center text-lg-start pe-lg-3 pe-xl-4">
                            <div class="headline text-white d-none d-sm-block">
                                <h1 class="mb-6 w-100 headline-responsive">{{ $landingPage->topBannerSection->headline ?? 'Headline' }}<br /></h1>
                                <ul class="ps-4" style="line-height: 2;">
                                    @if (!empty($landingPage->topBannerSection->highlights)) @foreach ($landingPage->topBannerSection->highlights as $highlight)
                                    <li class="fw-bold text-white fs-5">{{ $highlight['value'] ?? 'Highlight' }}</li>
                                    @endforeach @else
                                    <li class="fw-bold text-white fs-5">highlight 1</li>
                                    <li class="fw-bold text-white fs-5">highlight 2</li>
                                    <li class="fw-bold text-white fs-5">highlight 3</li>
                                    @endif
                                </ul>
                                <p class="fw-bold text-white d-block d-sm-none" style="font-size: 18px;">No voicemail, no waiting.</p>
                            </div>
                            <div class="headline text-white d-block d-sm-none">
                                <h1 class="mb-6 w-100">{{ $landingPage->topBannerSection->headline ?? 'Headline' }}<br /></h1>
                                <ul class="list-unstyled text-start mx-auto" style="width: fit-content;">
                                    @if (!empty($landingPage->topBannerSection->highlights)) @foreach ($landingPage->topBannerSection->highlights as $highlight)
                                    <li class="fw-bold text-white fs-5">{{ $highlight['value'] ?? 'Highlight' }}</li>
                                    @endforeach @else
                                    <li class="fw-bold text-white fs-5">highlight 1</li>
                                    <li class="fw-bold text-white fs-5">highlight 2</li>
                                    <li class="fw-bold text-white fs-5">highlight 3</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="mt-6 row">
                                <div class="d-none d-sm-block text-start mb-3">
                                    <img
                                        decoding="async"
                                        src="{{ $landingPage->topBannerSection && $landingPage->topBannerSection->testimonial_image
                                        ? asset('storage/' . $landingPage->topBannerSection->testimonial_image)
                                        : 'https://dummyimage.com/400x200/cccccc/000000&text=400x200' }}"
                                        alt="testimonials"
                                        class="img-fluid"
                                    />
                                </div>
                                <div class="d-none d-sm-block mt-6">
                                    <img
                                        decoding="async"
                                        src="{{ $landingPage->topBannerSection && $landingPage->topBannerSection->trusted_logos
                                        ? asset('storage/' . $landingPage->topBannerSection->trusted_logos)
                                        : 'https://dummyimage.com/400x100/cccccc/000000&text=400x100' }}"
                                        alt="awards"
                                        class="img-fluid"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mt-8 mt-lg-0 text-center text-lg-start ps-lg-3 ps-xl-4">
                            <div class="general-contact-form bg-light p-4 rounded-3">
                                <div>
                                    <h3 class="title-con-form bg-primary p-4 rounded-3 text-center text-white">Get Your Quote Today</h3>
                                </div>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <div id="hbspt-form-ff682f3a-5ec6-4423-9cad-7e8b3b3d1c47" class="hbspt-form py-4 px-1" data-hs-forms-root="true">
                                    <form id="contact-form" method="POST" action="{{ route('contactSubmission') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="pageId" value="{{ $landingPage->id }}" />

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="firstname" class="form-label">First name <span class="text-danger">*</span></label>
                                                <input id="firstname" name="firstname" required type="text" class="form-control" autocomplete="given-name" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="lastname" class="form-label">Last name <span class="text-danger">*</span></label>
                                                <input id="lastname" name="lastname" required type="text" class="form-control" autocomplete="family-name" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Company Email <span class="text-danger">*</span></label>
                                                <input id="email" name="email" required type="email" class="form-control" autocomplete="email" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                                <input id="phone" name="phone" required type="tel" class="form-control" autocomplete="tel" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="company" class="form-label">Company Name <span class="text-danger">*</span></label>
                                            <input id="company" name="company" required type="text" class="form-control" autocomplete="organization" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Describe any features your project must have <span class="text-danger">*</span></label>
                                            <p class="form-text">This can include ecommerce capabilities, specific apps it must integrate with, the platform it should be built on, etc.</p>
                                            <textarea id="message" class="form-control" name="message" required rows="4"></textarea>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <button type="submit" class="btn btn-warning fw-bold px-5 py-3 text-dark">Get My Quote</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="position-relative px-4 text-center py-8 py-md-12 py-xl-16" style="background: linear-gradient(to bottom, rgba(128, 128, 128, 0.53), rgba(128, 128, 128, 0)) no-repeat;padding: 5rem;">
                <div class="container mx-auto z-1 position-relative">
                    <div class="text-center">
                        <h2 class="mb-1">
                            {{ $landingPage->customWebDevSection->section_heading ?? 'Title' }}
                        </h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-xl-9 mx-auto">
                                <div class="text-center">
                                    <p class="mb-10">
                                        {{ $landingPage->customWebDevSection->subheading ?? 'Subtitle' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-around align-items-center mt-5">
                        @foreach ($landingPage->customWebDevSection->services ?? [ ['title' => 'title', 'icon' => 'https://dummyimage.com/200x200/cccccc/000000&text=200x200', 'description' => 'description'], ['title' => 'title', 'icon' =>
                        'https://dummyimage.com/200x200/cccccc/000000&text=200x200', 'description' => 'description'], ['title' => 'title', 'icon' => 'https://dummyimage.com/200x200/cccccc/000000&text=200x200', 'description' =>
                        'description'], ['title' => 'title', 'icon' => 'https://dummyimage.com/200x200/cccccc/000000&text=200x200', 'description' => 'description'] ] as $service)
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-10 mt-md-0 px-2 h-100">
                            <div class="card border-0 bg-transparent h-100 transition-all duration-100 hover-scale">
                                <img
                                    decoding="async"
                                    class="mx-auto w-50"
                                    src="{{ filter_var($service['icon'], FILTER_VALIDATE_URL) ? $service['icon'] : asset('storage/'.$service['icon']) }}"
                                    alt="Graphic illustration of {{ $service['title'] }}"
                                />
                                <div class="card-body mt-auto">
                                    <h4 class="fw-bold mt-1 fs-5">{{ $service['title'] }}</h4>
                                    <p class="mt-2 mb-6 px-2 fs-6">{{ $service['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center" style="margin-top: 30px;">
                        <a href="#custom-website-dev-hero" target="_self" class="btn btn-warning fw-bold px-5 py-3 mt-3 d-block">Start Building Today</a>
                    </div>
                </div>
            </section>
            <section id="security-posture-assessment" class="poion-relative px-4 text-center py-8 py-md-12 py-xl-16 bg-arc-white mt-3">
                <div class="container mx-auto position-relative z-1">
                    <div class="text-center">
                        <p class="eyebrow text-uppercase letter-spacing-2 mb-2">
                            {{ $landingPage->solutionSection->title ?? 'Section Name' }}
                        </p>
                        <h2 class="mb-4">
                            {{ $landingPage->solutionSection->title ?? 'Title' }}
                        </h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-9 col-xl-8">
                                <p class="lead">{{ $landingPage->solutionSection->subtitle ?? 'Subtitle' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5 g-4">
                        @foreach ($landingPage->solutionSection->solutions ?? [ ['title' => 'title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'description'], ['title' => 'title', 'icon' =>
                        'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'description'], ['title' => 'title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' =>
                        'description'], ['title' => 'title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'description'], ['title' => 'title', 'icon' =>
                        'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'description'], ['title' => 'title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' =>
                        'description'], ['title' => 'title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'description'] ] as $solution)
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-lg rounded-md hover-scale transition-all">
                                <div class="card-body text-center">
                                    <h3 class="fw-bold mb-3 fs-5">{{ $solution['title'] }}</h3>
                                    <div class="d-flex justify-content-center align-items-center mb-4" style="height: 3rem;">
                                        <img
                                            src="{{ filter_var($solution['icon'], FILTER_VALIDATE_URL) ? $solution['icon'] : asset('storage/' . $solution['icon']) }}"
                                            alt="{{ $solution['title'] }} icon"
                                            class="img-fluid"
                                            style="max-height: 100%; max-width: 100%;"
                                        />
                                    </div>
                                    <p class="text-muted fs-6">{{ $solution['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section id="extensive-platform" class="position-relative px-4 py-8 py-md-12 py-xl-16 bg-gradient-blue" style="margin-top: 100px;">
                <div class="container mx-auto position-relative z-3">
                    <div class="text-center">
                        <p class="eyebrow text-uppercase letter-spacing-2 mb-2">
                            {{ $landingPage->cmsCapabilitiesSection->title ?? 'Section Name' }}
                        </p>
                        <h2 class="mb-4">{{ $landingPage->cmsCapabilitiesSection->title ?? 'Title' }}</h2>
                    </div>
                    <div class="row align-items-center justify-content-center mt-0 mx-auto w-lg-80 w-xl-75">
                        <div class="col-12 col-lg-6 order-2 order-lg-1 mt-8 mt-lg-0 pe-lg-3 pe-xl-4">
                            <div class="text-center text-lg-start">
                                <p class="mb-4 fs-6">
                                    {{ $landingPage->cmsCapabilitiesSection->description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the
                                    1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.' }}
                                </p>
                                <ul class="red-diamond ps-0 py-4">
                                    @foreach ($landingPage->cmsCapabilitiesSection->bullet_points ?? [ ['value' => 'Bullet Point 1'], ['value' => 'Bullet Point 2'], ['value' => 'Bullet Point 3'], ['value' => 'Bullet Point 4'] ] as $point)
                                    <li class="fs-6">{{ $point['value'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 order-1 order-lg-2 position-relative z-1 flex-shrink-0 overflow-hidden ps-lg-3 ps-xl-4 text-center">
                            <img
                                decoding="async"
                                class="img-fluid d-inline-block w-lg-83"
                                src="{{ $landingPage->cmsCapabilitiesSection && $landingPage->cmsCapabilitiesSection->logos
                                ? asset('storage/'.$landingPage->cmsCapabilitiesSection->logos)
                                : 'https://dummyimage.com/500x300/cccccc/000000&text=500x300' }}"
                                alt="Wordpress, HubSpot, and Drupal logos"
                            />
                        </div>
                    </div>
                </div>
            </section>
            <section id="security-posture-assessment" class="position-relative px-4 text-center py-8 py-md-12 py-xl-16 bg-miles-light-blue" style="background-repeat: no-repeat; padding: 7rem;">
                <div class="container mx-auto position-relative z-1">
                    <div class="text-center">
                        <p class="eyebrow text-uppercase letter-spacing-2 mb-2">
                            {{ $landingPage->digitalMarketingSection->name ?? 'Section Name' }}
                        </p>
                        <h2 class="mb-4">
                            {{ $landingPage->digitalMarketingSection->title ?? 'Title' }}
                        </h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-9 col-xl-8">
                                <p class="lead">{{ $landingPage->digitalMarketingSection->subtitle ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5 g-4">
                        @foreach ($landingPage->digitalMarketingSection->services ?? [ [ 'title' => 'Title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Description' ], [ 'title' => 'Title',
                        'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Description' ], [ 'title' => 'Title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' =>
                        'Description' ], [ 'title' => 'Title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Description' ], [ 'title' => 'Title', 'icon' =>
                        'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Description' ] ] as $service)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-lg rounded-md hover-scale transition-all">
                                <div class="card-body text-center">
                                    <h3 class="fw-bold mb-3 fs-5">{{ $service['title'] }}</h3>
                                    <div class="d-flex justify-content-center align-items-center mb-4" style="height: 3rem;">
                                        <img
                                            src="{{ filter_var($service['icon'], FILTER_VALIDATE_URL) ? $service['icon'] : asset('storage/' . $service['icon']) }}"
                                            alt="{{ $service['title'] }} icon"
                                            class="img-fluid"
                                            style="max-height: 100%; max-width: 100%;"
                                        />
                                    </div>
                                    <p class="text-muted fs-6">{{ $service['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="position-relative px-4 text-center py-8 py-md-12 py-xl-16 p-4" style="margin-top: 75px;">
                <div class="container mx-auto position-relative z-1">
                    <div class="text-center">
                        <p class="eyebrow text-uppercase letter-spacing-2 mb-2">
                            {{ $landingPage->websiteManagementService->name ?? 'Section Name' }}
                        </p>
                        <h2 class="mb-4">
                            {{ $landingPage->websiteManagementService->title ?? 'Title' }}
                        </h2>
                        <div class="row justify-content-center">
                            <div class="col-lg-9 col-xl-8">
                                <p class="lead">{{ $landingPage->websiteManagementService->title ?? 'Description' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5 g-4">
                        <!-- Card 1 -->
                        @foreach ($landingPage->websiteManagementService->services ?? [ [ 'title' => 'Title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Subtitle' ], [ 'title' => 'Title', 'icon'
                        => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Subtitle' ], [ 'title' => 'Title', 'icon' => 'https://dummyimage.com/100x100/cccccc/000000&text=100x100', 'description' => 'Subtitle'
                        ] ] as $service)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-lg rounded-md hover-scale transition-all">
                                <div class="card-body text-center">
                                    <h3 class="fw-bold mb-3 fs-5">{{ $service['title'] }}</h3>
                                    <div class="d-flex justify-content-center align-items-center mb-4" style="height: 3rem;">
                                        <img
                                            src="{{ filter_var($service['icon'], FILTER_VALIDATE_URL) ? $service['icon'] : asset('storage/' . $service['icon']) }}"
                                            alt="{{ $service['title'] }} icon"
                                            class="img-fluid"
                                            style="max-height: 100%; max-width: 100%;"
                                        />
                                    </div>
                                    <p class="text-muted fs-6">{{ $service['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="position-relative text-center py-4 py-md-5 py-xl-5" style="margin-top: 50px;">
                <div class="container position-relative z-1">
                    <div class="text-center mb-4">
                        <p class="text-uppercase fw-semibold" style="letter-spacing: 0.075em;">
                            {{ $landingPage->portfolioSection->name ?? 'Section Name' }}
                        </p>
                        <h2 class="mt-2 fw-bold fs-3 fs-sm-4">{{ $landingPage->portfolioSection->section_title ?? 'Title' }}</h2>
                    </div>
                    <div class="row justify-content-around mt-4">
                        @foreach ($landingPage->portfolioSection->portfolio_items ?? [ ['image' => 'https://dummyimage.com/600x400/cccccc/000000&text=600x400'], ['image' => 'https://dummyimage.com/600x400/cccccc/000000&text=600x400'],
                        ['image' => 'https://dummyimage.com/600x400/cccccc/000000&text=600x400'], ] as $item)
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="transition-transform hover-zoom">
                                <img src="{{ filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : asset('storage/' . $item['image']) }}" class="img-fluid mx-auto d-block" alt="International Boxing Federation custom website" />
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="#custom-website-dev-hero" class="btn btn-warning text-dark fw-semibold px-4 py-2">Get Your Personal Quote Fast</a>
                    </div>
                </div>
            </section>
            <section id="milesit-main-review-cards-sec" class="py-5 text-center position-relative bg-white">
                <div class="container position-relative z-1">
                    <div class="text-center mb-4">
                        <p class="text-uppercase fw-semibold text-secondary mb-1">
                            {{ $landingPage->testimonialSection->name ?? 'Section Name'}}
                        </p>
                        <h2 class="fw-bold mb-3">{{ $landingPage->testimonialSection->section_title ?? 'Title'}}</h2>
                        <div class="mx-auto" style="max-width: 720px;">
                            <p class="text-muted">{{ $landingPage->testimonialSection->section_subtitle ?? 'Subtitle'}}</p>
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4">
                                <div>
                                    <p class="fs-4 fw-bold mb-1">4.8</p>
                                    <p><img src="{{ asset('images/star-icons.png') }}" alt="Star Ratings" style="height: 20px;" /></p>

                                    <p><a href="#" target="_blank" class="fw-semibold text-decoration-none fs-6">278 reviews</a></p>
                                </div>
                                <div>
                                    <img src="{{ asset('images/powered-by-google-icon.svg') }}" alt="Google Icons" style="height: 30px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mt-3">
                        @foreach ($landingPage->testimonialSection->testimonials ?? [ ['client_name' => 'Client Name', 'star_rating' => 5, 'testimonial_text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'], ['client_name' => 'Client Name', 'star_rating' => 5, 'testimonial_text' => 'Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'], ['client_name' => 'Client Name', 'star_rating' => 5, 'testimonial_text' => 'Lorem Ipsum is simply dummy text of
                        the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.'] ] as $testimonial)
                        <div class="col-sm-6 col-md-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">{{ $testimonial['client_name'] }}</h5>
                                    <div class="mx-auto my-3 d-flex justify-content-center" style="height: 48px;">
                                        @for ($i = 1; $i <= 5; $i++)
                                        <img src="{{ asset('images/' . ($i <= $testimonial['star_rating'] ? 'star-filled.svg' : 'star-outline.svg')) }}" alt="star" style="height: 20px; width: 20px;" class="mx-1" />
                                        @endfor
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <img src="{{ asset('images/google.png') }}" alt="Google Icon" style="height: 20px;" class="me-2" />
                                        <span class="text-muted small">10 months ago</span>
                                    </div>
                                    <p class="card-text text-muted fs-6">{{ $testimonial['testimonial_text'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="position-relative py-4 py-md-5 py-xl-5 px-3 bg-white">
                <div class="container position-relative z-2">
                    <div class="mt-4 text-start w-100 w-lg-80 w-xl-75 mx-auto"></div>
                    <div class="text-center">
                        <h2 class="fw-bold lh-sm mb-3" style="font-family: 'Titillium Web', sans-serif; font-size: 1.875rem; letter-spacing: 0.03em;">
                            {{ $landingPage->finalCTASection->heading ?? 'Title' }}
                        </h2>
                    </div>
                    <div class="mt-4 text-center">
                        <a
                            href="#custom-website-dev-hero"
                            target="_self"
                            class="btn btn-lg px-4 py-3 text-dark"
                            style="background-color: #ffbb33; border-radius: 0.375rem; font-size: 1.25rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1); font-family: 'Titillium Web', sans-serif;"
                        >
                            {{ $landingPage->finalCTASection->button_text ?? 'Button Text' }}
                        </a>
                    </div>
                </div>
            </section>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
