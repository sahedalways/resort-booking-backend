<x-layouts.app>
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold text-white">Resort Details</h3>
            <a href="{{ route('admin.resort-manage.index') }}" class="btn btn-sm btn-outline-success text-white">← Back to
                List</a>
        </div>

        <!-- Resort Main Card -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body p-4">

                <!-- Top Info -->
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h4 class="fw-bold mb-2 mb-md-0">{{ $resort->name }}</h4>
                    {!! activeBadge($resort->is_active, $resort->id) !!}
                </div>
                <p class="text-muted mb-4">{{ $resort->desc }}</p>

                <!-- Resort Info Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">📍 Location</p>
                            <p class="mb-0">{{ $resort->location }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">📏 Distance</p>
                            <p class="mb-0">{{ $resort->distance }} km</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🏨 Package Type</p>
                            <p class="mb-0">
                                <i class="{{ $resort->packageType->icon }}"></i>
                                {{ $resort->packageType->type_name }}
                                @if ($resort->packageType->is_refundable)
                                    <span class="badge bg-info text-dark ms-2">Refundable</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🕑 Check-In / Check-Out</p>
                            <p class="mb-0">
                                <strong>Day:</strong> {{ $resort->d_check_in }} - {{ $resort->d_check_out }}<br>
                                <strong>Night:</strong> {{ $resort->n_check_in }} - {{ $resort->n_check_out }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">🏋️ Facilities & Services</h5>

                    @php
                        $i = 1;

                        $groupedFacilities = $resort->facilities->groupBy('facility_id');
                    @endphp

                    @forelse ($groupedFacilities as $facilityId => $services)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    @if ($services->first()->facility)
                                        <i class="{{ $services->first()->facility->icon }} me-2 text-primary"></i>
                                        <h6 class="fw-semibold mb-0">
                                            {{ $services->first()->facility->name }}
                                        </h6>
                                    @else
                                        <span class="text-muted">No Facility</span>
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($services as $service)
                                        <span
                                            class="badge bg-gradient-info text-white px-3 py-2 shadow-sm d-flex align-items-center position-relative">
                                            @if ($service->icon)
                                                <i class="{{ $service->icon }} me-1"></i>
                                            @endif
                                            {{ $service->type_name }}


                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No facilities added.</p>
                    @endforelse
                </div>




                <!-- Additional Facts -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">📌 Additional Facts</h5>

                    @if ($resort->additionalFacts->count())
                        <div class="d-flex flex-column gap-3">
                            @foreach ($resort->additionalFacts as $fact)
                                <div class="bg-light p-3 rounded shadow-sm">
                                    <strong>{{ $fact->name }}</strong>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No additional facts available.</p>
                    @endif
                </div>


                <!-- Gallery -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">🖼 Gallery</h5>

                    @if ($resort->images->count())
                        <div class="text-center" style="max-width: 450px; margin: auto;">

                            <!-- Main Carousel -->
                            <div id="resortCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($resort->images as $image)
                                        <div class="carousel-item @if ($loop->first) active @endif">
                                            <div class="d-flex justify-content-center align-items-center"
                                                style="width: 400px; height: 250px; overflow: hidden; margin: auto;">
                                                <img src="{{ asset(getFileUrl($image->image)) }}"
                                                    class="d-block rounded shadow-sm"
                                                    style="object-fit: cover; width: 100%; height: 100%;"
                                                    alt="Resort Image">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Carousel controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#resortCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#resortCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                            <!-- Thumbnails -->
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                @foreach ($resort->images as $key => $image)
                                    <div style="width: 70px; height: 50px; overflow: hidden; cursor: pointer;">
                                        <img src="{{ asset(getFileUrl($image->image)) }}" class="rounded shadow-sm"
                                            style="object-fit: cover; width: 100%; height: 100%;"
                                            data-bs-target="#resortCarousel" data-bs-slide-to="{{ $key }}"
                                            alt="Thumbnail">
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @else
                        <p class="text-muted">No images uploaded.</p>
                    @endif
                </div>





            </div>
        </div>

    </div>
</x-layouts.app>
