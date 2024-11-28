@extends('layouts.app')
@section('title', 'Chỉ dẫn điểm đến')
@section('description', 'Chỉ dẫn điểm đến')
@section('keyword', 'Chỉ dẫn điểm đến')
@push('styles')
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

        .icon-business-field {
            width: 30px;
            height: 30px;
            object-fit: cover;
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
            <div class="col-12 col-lg-8">
                <div class="position-relative">
                    <div id="map" style="height: 700px;"></div>
                    <div class="position-absolute w-100 form-filter">
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <select class="form-select" name="business_field" id="business-field">
                                    <option value="" selected>Tất cả</option>
                                    @foreach ($business_fields as $businessField)
                                        <option value="{{ $businessField->id }}">{{ $businessField->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-9 mt-2 mt-sm-0">
                                <input name="search" type="text" id="place-name" class="form-control w-100"
                                    placeholder="Nhập tên địa điểm">
                                <div id="search-results" class="list-group position-absolute w-auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 px-3">
                <div class="mt-3 mt-lg-0">
                    <h4 class="text-center">Danh sách địa điểm</h4>
                    <p class="text-center">Hiển thị {{ $locations->count() }} trên tổng số {{ $locations->total() }} địa
                        điểm</p>
                    <x-pagination :paginator="$locations" />
                    <div class="row g-2 scrollable-list">
                        @foreach ($locations as $location)
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="border rounded-4 p-3 h-100 info-location-container"
                                    onclick="selectLocation({{ $location }},{{ $location->address_latitude }},{{ $location->address_longitude }},'{{ $location->businessField->icon }}')">
                                    <div class="info-location-content">
                                        <div class="info-location">
                                            <span>Thông tin vị trí</span>
                                            <div class="d-flex align-items-center my-2 ">
                                                <img class="img-location rounded-circle me-3"
                                                    src="{{ asset($location->businessMember->business->avt_businesses) }}" alt="{{ $location->name }}"
                                                    loading="lazy">
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places&v=weekly"
        async></script>
    <script>
        let map, infowindow, service, marker;
        const markers = [];
        const domain = window.location.origin;

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

            loadLocations();
        }

        function loadLocations() {
            $.getJSON('/client/get-locations', (locations) => {
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


            map.setCenter(location);
            placeMarker(location, fullIconUrl);
            getGeocode(location);
           
            console.log(isLocation);
            

            const locationDetails = `
                <div class="info-location">
                    <div class="h-100 info-location-container mb-3">
                        <div class="info-location-content">
                            <div class="info-location">
                                <strong>Thông tin vị trí:</strong>
                                <div class="d-flex align-items-center my-2">
                                    <img class="img-location rounded-circle me-3" src="${domain}/${isLocation.image}" alt="${isLocation.name}" loading="lazy">
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
                            <div class="mt-3">
                                <div class="d-flex">
                                    <strong>Mô tả: </strong>
                                    <p>${isLocation.description}</p>
                                </div>
                                ${isLocation.location_products && isLocation.location_products.length > 0 ? `
                                                   
                                        <div class="mt-3">
                                            ${isLocation.location_products.map(product => `
                                            <div class="d-flex">
                                                ${product.media_type === 'image' ? `
                                                        <img src="${domain}/${product.file_path}" alt="${product.id}" class="img-fluid mb-2">
                                                        ` : `
                                                        <video controls class="img-fluid">
                                                                <source src="${domain}/${product.file_path}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    `}
                                            </div>
                                        `).join('')}
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

        function getGeocode(latLng) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                location: latLng
            }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const address = results[0].formatted_address;
                    infowindow.setContent(address);
                    infowindow.open(map, marker);
                    $('#place-name').val(address);

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
                business_field: businessField
            }, function(results) {
                displaySearchResults(results);
            }).fail(function() {
                console.error('Error');
                $('#search-results').html('<div class="list-group-item">Không tìm thấy kết quả</div>');
            });
        }

        function displaySearchResults(results) {
            const searchResults = $('#search-results').empty();

            results.forEach(result => {
                $('<div>', {
                    class: 'list-group-item list-group-item-action',
                    text: `${result.name} - ${result.address_address}`,
                    click: () => {
                        const location = new google.maps.LatLng(parseFloat(result.address_latitude),
                            parseFloat(result.address_longitude));
                        const iconUrl = result.business_field.icon ?
                            `${domain}/${result.business_field.icon}` :
                            `${domain}/images/icon/icon_location.png`;

                        map.setCenter(location);
                        placeMarker(location, iconUrl);
                        getGeocode(location);
                        searchResults.empty();
                        $('#place-name').val(result.name);
                    }
                }).appendTo(searchResults);
            });
        }
    </script>
@endpush
