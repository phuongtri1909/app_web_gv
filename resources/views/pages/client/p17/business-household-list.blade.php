@foreach ($businessHouseholds as $index => $item)
<tr>
    <td>{{ ($businessHouseholds->currentPage() - 1) * $businessHouseholds->perPage() + $loop->iteration }}</td>
    <td><p class="w-max-content">{{ $item->license_number }}</p></td>
    <td><p class="w-max-content">{{ $item->business_owner_full_name }}</p></td>
    <td><p class="w-max-content">{{ $item->signboard }}</p></td>
    <td><p class="w-max-content">{{ $item->address }}</p></td>
    <td><a href="#" class="btn btn-info btn-sm w-max-content">Xem chi tiết</a></td>
</tr>
@endforeach