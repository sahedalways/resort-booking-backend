<x-layouts.app>
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold text-white">Day Long Details</h3>
            <a href="{{ route('admin.daylong-manage.index') }}" class="btn btn-sm btn-outline-success text-white">
                ← Back to List
            </a>
        </div>

        <!-- Main Card -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body p-4">

                <!-- Top Info -->
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h4 class="fw-bold mb-2 mb-md-0">{{ $daylongData->name ?? 'N/A' }}</h4>
                    {!! activeBadge($daylongData->is_active ?? 0, $daylongData->id ?? null) !!}
                </div>

                <p class="text-muted mb-4">{{ $daylongData->desc ?? 'No description available.' }}</p>

                <!-- Info Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🏨 Resort</p>
                            <p class="mb-0">{{ $daylongData->resort->name ?? 'N/A' }}</p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🌅 View Type</p>
                            <p class="mb-0">{{ $daylongData->viewType->name ?? 'Full View' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">👨‍👩‍👧 Capacity</p>
                            <p class="mb-0">{{ $daylongData->capacity ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">💰 Price</p>
                            <p class="mb-0">
                                {{ $daylongData->price ?? 0 }}
                                ({{ $daylongData->price_per ?? 'N/A' }})
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">🛎 Services</h5>
                    @if ($daylongData->services && $daylongData->services->count())
                        <ul class="list-group">
                            @foreach ($daylongData->services as $serviceInfo)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="{{ $serviceInfo->service->icon ?? 'fas fa-check' }} me-2"></i>
                                        {{ $serviceInfo->service->type_name ?? 'N/A' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No services available.</p>
                    @endif
                </div>

                <!-- Rate Details -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">📋 Rate Details</h5>
                    @if ($daylongData->rateDetails && $daylongData->rateDetails->count())
                        <ul class="list-group">
                            @foreach ($daylongData->rateDetails as $rate)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $rate->title }}
                                    {!! activeBadge($rate->is_active ?? 0) !!}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No rate details added.</p>
                    @endif
                </div>

                <!-- Gallery -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">🖼 Gallery</h5>
                    @if ($daylongData->images && $daylongData->images->count())
                        <div class="text-center" style="max-width: 450px; margin: auto;">
                            <!-- Main Carousel -->
                            <div id="daylongCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($daylongData->images as $image)
                                        <div class="carousel-item @if ($loop->first) active @endif">
                                            <div class="d-flex justify-content-center align-items-center"
                                                style="width: 400px; height: 250px; overflow: hidden; margin: auto;">
                                                <img src="{{ asset(getFileUrl($image->image)) }}"
                                                    class="d-block rounded shadow-sm"
                                                    style="object-fit: cover; width: 100%; height: 100%;"
                                                    alt="Daylong Image">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#daylongCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#daylongCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>

                            <!-- Thumbnails -->
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                @foreach ($daylongData->images as $key => $image)
                                    <div style="width: 70px; height: 50px; overflow: hidden; cursor: pointer;">
                                        <img src="{{ asset(getFileUrl($image->image)) }}" class="rounded shadow-sm"
                                            style="object-fit: cover; width: 100%; height: 100%;"
                                            data-bs-target="#daylongCarousel" data-bs-slide-to="{{ $key }}"
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
