@foreach ($businessHouseholds as $index => $item)
<tr>
    <td>{{ ($businessHouseholds->currentPage() - 1) * $businessHouseholds->perPage() + $loop->iteration }}</td>
    <td>{{ $item->license_number }}</td>
    <td>{{ $item->business_owner_full_name }}</td>
    <td>{{ $item->signboard }}</td>
    <td>{{ $item->address }}</td>
    <td><a href="#" class="btn btn-info btn-sm">Xem chi tiết</a></td>
</tr>
@endforeach