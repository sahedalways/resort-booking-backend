<x-layouts.app>
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold text-white">Room Details</h3>
            <a href="{{ route('admin.room-manage.index') }}" class="btn btn-sm btn-outline-success text-white">
                ← Back to List
            </a>
        </div>

        <!-- Main Card -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body p-4">

                <!-- Top Info -->
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h4 class="fw-bold mb-2 mb-md-0">{{ $room->name }}</h4>
                    {!! activeBadge($room->is_active, $room->id) !!}
                </div>
                <p class="text-muted mb-4">{{ $room->desc }}</p>

                <!-- Info Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🏨 Resort</p>
                            <p class="mb-0">{{ $room->resort->name ?? 'N/A' }}</p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">📐 Area</p>
                            <p class="mb-0">{{ $room->area ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🎁 Package Name</p>
                            <p class="mb-0">{{ $room->package_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🛏 Bed Type</p>
                            <p class="mb-0">{{ $room->bedType->type_name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">🌅 View Type</p>
                            <p class="mb-0">{{ $room->viewType->type_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">👨‍👩‍👧 Capacity</p>
                            <p class="mb-0">Adults: {{ $room->adult_cap }} | Children: {{ $room->child_cap }}</p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded shadow-sm h-100">
                            <p class="mb-1 fw-semibold">💰 Price</p>
                            <p class="mb-0">{{ $room->price }} (Per: {{ $room->price_per }})</p>
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">🛎 Services</h5>
                    @if ($room->services->count())
                        <ul class="list-group">
                            @foreach ($room->services as $serviceInfo)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="{{ $serviceInfo->service->icon ?? 'fas fa-check' }} me-2"></i>
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
                    @if ($room->rateDetails->count())
                        <ul class="list-group">
                            @foreach ($room->rateDetails as $rate)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $rate->title }}
                                    {!! activeBadge($rate->is_active) !!}
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
                    @if ($room->images->count())
                        <div class="text-center" style="max-width: 450px; margin: auto;">
                            <!-- Main Carousel -->
                            <div id="roomCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($room->images as $image)
                                        <div class="carousel-item @if ($loop->first) active @endif">
                                            <div class="d-flex justify-content-center align-items-center"
                                                style="width: 400px; height: 250px; overflow: hidden; margin: auto;">
                                                <img src="{{ asset(getFileUrl($image->image)) }}"
                                                    class="d-block rounded shadow-sm"
                                                    style="object-fit: cover; width: 100%; height: 100%;"
                                                    alt="Room Image">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>

                            <!-- Thumbnails -->
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                @foreach ($room->images as $key => $image)
                                    <div style="width: 70px; height: 50px; overflow: hidden; cursor: pointer;">
                                        <img src="{{ asset(getFileUrl($image->image)) }}" class="rounded shadow-sm"
                                            style="object-fit: cover; width: 100%; height: 100%;"
                                            data-bs-target="#roomCarousel" data-bs-slide-to="{{ $key }}"
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
