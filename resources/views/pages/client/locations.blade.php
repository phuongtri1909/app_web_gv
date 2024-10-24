@extends('pages.layouts.page')
@section('title', 'Chỉ dẫn điểm đến')
@section('description', 'Chỉ dẫn điểm đến')
@section('keyword', 'Chỉ dẫn điểm đến')
@push('styles')
    <style>
        #map {
            height: 100%;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
@endpush

@push('scripts')
    <script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places&v=weekly"
    async
    ></script>
    <script>
        let map;
        let marker;
        let infowindow;
        let service;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 10.8231, lng: 106.6297 }, // Ho Chi Minh City, Vietnam
                zoom: 10,
            });

            map.addListener("click", (event) => {
                placeMarker(event.latLng);
            });

            infowindow = new google.maps.InfoWindow();
            service = new google.maps.places.PlacesService(map);
        }

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
            }
            console.log("Marker position: ", location.lat(), location.lng());
        }

        function searchPlace() {
            const placeName = document.getElementById('place-name').value;
            const request = {
                query: placeName,
                fields: ['name', 'geometry'],
            };

            service.findPlaceFromQuery(request, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK && results) {
                    const place = results[0];
                    map.setCenter(place.geometry.location);
                    placeMarker(place.geometry.location);
                    infowindow.setContent(place.name);
                    infowindow.open(map, marker);
                } else {
                    alert('Place not found');
                }
            });
        }
    </script>
@endpush

@section('content')
    @include('pages.components.button-register', [
        'buttonTitle' => 'ĐK Điểm đến',
        'buttonLink' => route('show.form.promotional'),
    ])

<div class="mt-5rem">

    <div class="container my-4 ">
        <div class="row mb-3">
            <div class="col-md-8">
                <input type="text" id="place-name" class="form-control" placeholder="Nhập tên địa điểm">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary" onclick="searchPlace()">Tìm kiếm</button>
            </div>
        </div>
        <div id="map" style="height: 700px;"></div>
    </div>
</div>
@endsection