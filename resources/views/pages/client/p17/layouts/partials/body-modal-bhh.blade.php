<p><strong>Số giấy phép:</strong> {{ $businessHousehold->license_number }}</p>
<p><strong>Ngày cấp:</strong> {{ $businessHousehold->date_issued }}</p>
<p><strong>Họ tên chủ hộ:</strong> {{ $businessHousehold->business_owner_full_name }}</p>
<p><strong>Ngày sinh chủ hộ:</strong> {{ $businessHousehold->business_dob }}</p>
<p><strong>Số nhà:</strong> {{ $businessHousehold->house_number }}</p>
<p><strong>Đường:</strong> {{ $businessHousehold->road->name }}</p>
<p><strong>Bảng hiệu:</strong> {{ $businessHousehold->signboard }}</p>
<p><strong>Lĩnh vực kinh doanh:</strong> {{ $businessHousehold->business_field }}</p>
<p><strong>Số điện thoại:</strong> {{ $businessHousehold->phone ?? 'Chưa cập nhật' }}</p>
<p><strong>Số CCCD:</strong> {{ $businessHousehold->cccd }}</p>
<p><strong>Địa chỉ:</strong> {{ $businessHousehold->address }}</p>
<p><strong>Trạng thái:</strong> <span class="badge rounded-pill text-bg-success">{{ $businessHousehold->status }}</span></p>