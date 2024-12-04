@extends('layouts.app')

@if (Route::currentRouteName() == 'locations')
    @section('title', 'Chỉ dẫn điểm đến')
    @section('description', 'Chỉ dẫn điểm đến')
    @section('keyword', 'Chỉ dẫn điểm đến')
@elseif(Route::currentRouteName() == 'locations-17')
    @section('title', 'Giới Thiệu Phường 17')
    @section('description', 'Giới Thiệu Phường 17')
    @section('keyword', 'Giới Thiệu Phường 17')
@endif

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <style>
        .form-filter {
            width: calc(100% - 70px) !important;
            top: 10px;
            left: 10px;
        }

        .info-location {
            border-bottom: thick double #32a1ce;
        }

        .info-location-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .info-location-content {
            flex-grow: 1;
        }

        .info-location-button {
            margin-top: auto;
        }

        .scrollable-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .img-location {
            width: 70px;
            height: 70px;
            object-fit: scale-down;
        }

        .img-locations{
            object-fit: scale-down;
        }

        .icon-business-field {
            width: 30px;
            height: 30px;
            object-fit: cover;
        }

        #search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        #map {
            height: 450px;
        }

        @media (min-width: 768px) {
            #map {
                height: 700px;
            }
        }
    </style>
@endpush



@section('content')
    @if (Route::currentRouteName() == 'locations')
        @include('pages.components.button-register', [
            'buttonTitle' => 'Đăng ký điểm đến',
            'buttonLink' => route('show.form.promotional'),
        ])
    @endif

    <div class="mt-5rem">
        <div class="row mb-3 g-0">
            <div class="col-12 col-lg-4 px-3">
                <div class="mt-3 mt-lg-0">
                    <h4 class="text-center">
                        @if (Route::currentRouteName() == 'locations')
                            Danh sách địa điểm
                        @elseif(Route::currentRouteName() == 'locations-17')
                            Giới Thiệu Phường 17
                        @endif
                    </h4>
                    <p class="text-center">Hiển thị {{ $locations->count() }} trên tổng số {{ $locations->total() }}
                        @if (Route::currentRouteName() == 'locations')
                            địa điểm
                        @elseif(Route::currentRouteName() == 'locations-17')
                            địa điểm
                        @endif
                    </p>

                    <div class=" w-100 mb-3">
                        <div class="row">
                            <div class="col-12 ">
                                <select class="form-select w-100" name="business_field" id="business-field">
                                    <option value="" selected>Tất cả</option>
                                    @foreach ($business_fields as $businessField)
                                        <option value="{{ $businessField->id }}">{{ $businessField->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-2 w-100 position-relative">
                                <input name="search" type="text" id="place-name" class="form-control w-100"
                                    placeholder="Nhập tên địa điểm">
                                <div id="search-results" class="list-group w-100"></div>
                            </div>
                        </div>
                    </div>

                    <x-pagination :paginator="$locations" />
                    <div class="row g-2 scrollable-list">
                        @foreach ($locations as $location)
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="border rounded-4 p-3 h-100 info-location-container"
                                    onclick="selectLocation({{ $location }},{{ $location->address_latitude }},{{ $location->address_longitude }},'{{ $location->businessField->icon ?? '' }}')">
                                    <div class="info-location-content">
                                        <div class="info-location">
                                            <span>Thông tin vị trí</span>
                                            <div class="d-flex align-items-center my-2 ">
                                                <img class="img-location rounded-circle me-3"
                                                    src="{{ isset($location->businessMember->business) ? asset($location->businessMember->business->avt_businesses) : asset('images/business/business_default.webp') }}"
                                                    alt="{{ $location->name }}" loading="lazy">
                                                <div class="d-flex flex-column">
                                                    <h5>{{ $location->name }}</h5>
                                                    <div class="d-flex align-items-center">

                                                        <img class="icon-business-field"
                                                            src="{{ asset($location->businessField->icon ?? '/images/icon/icon_location.png') }}"
                                                            alt="{{ $location->businessField->name }}" loading="lazy">
                                                        <span>{{ $location->businessField->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="d-flex">
                                                <strong>Địa chỉ: </strong>
                                                <p>{{ $location->address_address }}</p>
                                            </div>
                                            <div class="d-flex">
                                                <strong>Tọa độ: </strong>
                                                <p class="mb-0">{{ $location->address_latitude }} -
                                                    {{ $location->address_longitude }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end info-location-button">
                                        <button title="Chỉ đường" class="btn btn-info text-white"
                                            onclick="openDirections({{ $location->address_latitude }}, {{ $location->address_longitude }})">
                                            <i class="fa-solid fa-location-arrow"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 mt-3">
                <div class="position-relative">
                    <div id="map"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="locationOffcanvas" aria-labelledby="locationOffcanvasLabel">
        <div class="offcanvas-header justify-content-start">
            <button type="button" class="btn-close me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <h5 class="offcanvas-title text-center" id="locationOffcanvasLabel">Thông tin địa điểm</h5>
        </div>
        <div class="offcanvas-body">
            <div id="locationDetails">
                <!-- Thông tin chi tiết của địa điểm sẽ được load vào đây -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places&v=weekly"
        async></script>
    <script>
        let map, infowindow, service, marker;
        const markers = [];
        const domain = window.location.origin;
        const currentRouteName = "{{ Route::currentRouteName() }}";

        function initMap() {
            map = new google.maps.Map($("#map")[0], {
                center: {
                    lat: 10.8231,
                    lng: 106.6297
                },
                zoom: 10,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.BOTTOM_LEFT
                }
            });

            infowindow = new google.maps.InfoWindow();
            service = new google.maps.places.PlacesService(map);

            loadLocations(currentRouteName);
        }

        function loadLocations(routeName) {
            $.getJSON('/client/get-locations', {
                route_name: routeName
            }, (locations) => {
                locations.forEach(location => {
                    const iconUrl = location.business_field.icon ?
                        `${domain}/${location.business_field.icon}` :
                        `${domain}/images/icon/icon_location.png`;

                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(location.address_latitude),
                            lng: parseFloat(location.address_longitude)
                        },
                        map: map,
                        title: location.name,
                        icon: {
                            url: iconUrl,
                            scaledSize: new google.maps.Size(40, 40)
                        }
                    });

                    marker.addListener('click', () => {
                        const content = `
                                <div>
                                    <strong>${location.name}</strong><br>
                                    ${location.address_address}<br>
                                    <button class="mt-2 btn btn-sm btn-success" onclick="openDirections(${location.address_latitude}, ${location.address_longitude})">Đường đi</button>
                                </div>
                            `;
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    });

                    markers.push(marker);
                });
            }).fail(() => console.error('Lỗi không thể tải location'));
        }

        function openDirections(lat, lng) {
            const url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
            window.open(url, '_blank');
        }

        function selectLocation(isLocation, lat, lng, iconUrl) {

            const location = new google.maps.LatLng(lat, lng);
            const fullIconUrl = iconUrl ?
                `${domain}/${iconUrl}` :
                `${domain}/images/icon/icon_location.png`;

            const defaultImage = `${domain}/images/business/business_default.webp`;
            const businessImage = isLocation.business_member && isLocation.business_member.business ?
                `${domain}/${isLocation.business_member.business.avt_businesses}` : defaultImage;



            map.setCenter(location);
            placeMarker(location, fullIconUrl);
            getGeocode(location);

            const locationDetails = `
                <div class="info-location">
                    <div class="h-100 info-location-container mb-3">
                        <div class="info-location-content">
                            <div class="info-location">
                                <strong>Thông tin vị trí:</strong>
                                <div class="d-flex align-items-center my-2">
                                    <img class="img-location rounded-circle me-3" src="${businessImage}" alt="${businessImage}" loading="lazy">
                                    <div class="d-flex flex-column">
                                        <h5>${isLocation.name}</h5>
                                        <div class="d-flex align-items-center">
                                            <img class="icon-business-field" src="${domain}/${isLocation.business_field.icon ?? '/images/icon/icon_location.png'}" alt="${isLocation.business_field.name}" loading="lazy">
                                            <span>${isLocation.business_field.name}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex">
                                    <strong>Địa chỉ: </strong>
                                    <p>${isLocation.address_address}</p>
                                </div>
                                <div class="d-flex">
                                    <strong>Tọa độ: </strong>
                                    <p class="mb-0">${isLocation.address_latitude} - ${isLocation.address_longitude}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-location-container mt-3">
                    <div class="info-location-content">
                        <strong>Thông tin mô tả:</strong>
                        <div class="mt-3 overflow-auto">
                            <div class="d-flex">
                                <div>${isLocation.description}</div> 
                             </div>
                             ${isLocation.location_products && isLocation.location_products.length > 0 ? `             
                                <div class="row mt-3">
                                    ${isLocation.location_products.map(product => `
                                        <div class="col-6">
                                            ${product.media_type === 'image' ? `
                                                <a href="${domain}/${product.file_path}" data-fancybox="gallery">
                                                    <img src="${domain}/${product.file_path}" alt="${product.id}" class="img-fluid mb-2 img-locations">
                                                </a>
                                            ` : `
                                                <a href="${domain}/${product.file_path}" data-fancybox="gallery" data-caption="Video">
                                                    <video controls class="img-fluid">
                                                        <source src="${domain}/${product.file_path}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </a>
                                            `}
                                        </div>
                                    `).join('')}
                                </div>                      
                                ` : ''}

                                ${isLocation.link_video ? `
                                    <div class="mt-3">
                                        <strong>Video giới thiệu:</strong>
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item w-100" src="${getYouTubeEmbedUrl(isLocation.link_video)}" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                        <div class="text-end info-location-button">
                            <button title="Chỉ đường" class="btn btn-info text-white" onclick="openDirections(${isLocation.address_latitude}, ${isLocation.address_longitude})">
                                <i class="fa-solid fa-location-arrow"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $('#locationDetails').html(locationDetails);

            const offcanvas = new bootstrap.Offcanvas(document.getElementById('locationOffcanvas'));
            offcanvas.show();
        }

        function getYouTubeEmbedUrl(url) {
            const videoId = url.split('v=')[1];
            const ampersandPosition = videoId.indexOf('&');
            if (ampersandPosition !== -1) {
                return `https://www.youtube.com/embed/${videoId.substring(0, ampersandPosition)}`;
            }
            return `https://www.youtube.com/embed/${videoId}`;
        }

        function getGeocode(latLng) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                location: latLng
            }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const address = results[0].formatted_address;
                    infowindow.setContent(address);
                    infowindow.open(map, marker);
                    //$('#place-name').val(address);

                    service.getDetails({
                        placeId: results[0].place_id
                    }, (place, status) => {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            const content = `
                                    <div>
                                        <strong>${place.name}</strong><br>
                                        ${place.formatted_address}<br>
                                        <button class="mt-2 btn btn-sm btn-success" onclick="openDirections(${latLng.lat()}, ${latLng.lng()})">Đường đi</button>
                                    </div>
                                `;
                            infowindow.setContent(content);
                            infowindow.open(map, marker);
                        }
                    });
                } else {
                    showToast('Không tìm thấy kết quả', 'error');
                }
            });
        }

        function placeMarker(location, fullIconUrl) {
            markers.forEach(m => m.setMap(null));
            markers.length = 0;

            marker = new google.maps.Marker({
                position: location,
                map: map,
                icon: {
                    url: fullIconUrl,
                    scaledSize: new google.maps.Size(40, 40)
                }
            });

            marker.addListener('click', () => {
                infowindow.setContent('Đang tải...');
                infowindow.open(map, marker);
                getGeocode(location);
            });
        }

        $('#place-name').on('input', debounce(searchPlace, 500));
        $('#place-name').on('focus', searchPlace);
        $('#place-name').on('blur', () => $('#search-results').empty());
        $('#business-field').on('change', searchPlace);

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function searchPlace() {
            const placeName = $('#place-name').val();
            const businessField = $('#business-field').val();


            $.getJSON(`/client/search-locations`, {
                query: placeName,
                business_field: businessField,
                route_name: currentRouteName
            }, function(results) {
                displaySearchResults(results);
            }).fail(function() {
                console.error('Error');
                $('#search-results').html('<div class="list-group-item">Không tìm thấy kết quả</div>');
            });
        }

        function displaySearchResults(results) {
            
            const searchResultsContainer = $('.scrollable-list').empty();

            results.forEach(result => {
                const businessImage = result.business_member && result.business_member.business ? 
                    `${domain}/${result.business_member.business.avt_businesses}` : 
                    `${domain}/images/business/business_default.webp`;

                const iconUrl = result.business_field.icon ? 
                    `/${result.business_field.icon}` : 
                    `/images/icon/icon_location.png`;
            
                const resultHtml = `
                    <div class="col-12 col-sm-6 col-lg-12">
                        <div class="border rounded-4 p-3 h-100 info-location-container"
                            onclick='selectLocation(${JSON.stringify(result)}, ${result.address_latitude}, ${result.address_longitude}, "${iconUrl}")'>
                            <div class="info-location-content">
                                <div class="info-location">
                                    <span>Thông tin vị trí</span>
                                    <div class="d-flex align-items-center my-2">
                                        <img class="img-location rounded-circle me-3"
                                            src="${businessImage}" alt="${result.name}" loading="lazy">
                                        <div class="d-flex flex-column">
                                            <h5>${result.name}</h5>
                                            <div class="d-flex align-items-center">
                                                <img class="icon-business-field" src="${iconUrl}" alt="${result.business_field.name}" loading="lazy">
                                                <span>${result.business_field.name}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex">
                                        <strong>Địa chỉ: </strong>
                                        <p>${result.address_address}</p>
                                    </div>
                                    <div class="d-flex">
                                        <strong>Tọa độ: </strong>
                                        <p class="mb-0">${result.address_latitude} - ${result.address_longitude}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end info-location-button">
                                <button title="Chỉ đường" class="btn btn-info text-white" onclick="openDirections(${result.address_latitude}, ${result.address_longitude})">
                                    <i class="fa-solid fa-location-arrow"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                searchResultsContainer.append(resultHtml);
            });
        }
    </script>
@endpush
