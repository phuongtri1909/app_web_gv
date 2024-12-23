<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên doanh nghiệp</th>
            <th>Mã doanh nghiệp</th>
            <th>Địa chỉ</th>
            <th>Email</th>
            <th>SĐT Zalo</th>
            <th>Ngành nghề</th>
            <th>Tên người đại diện</th>
            <th>SĐT người đại diện</th>
            <th>Link</th>
            <th>Trạng thái</th>
            <th>Ngày đăng ký</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($BusinessMembers as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->business_name }}</td>
                <td>{{ $member->business_code }}</td>
                <td>{{ $member->address }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone_zalo }}</td>
                <td>
                    @if ($member->businessField)
                        {{ $member->businessField->name }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $member->representative_full_name }}</td>
                <td>{{ $member->representative_phone }}</td>
                <td>{{ $member->link }}</td>
                <td>
                    @if ($member->status == 'approved')
                        <span class="badge badge-success">Đã duyệt</span>
                    @elseif($member->status == 'pending')
                        <span class="badge badge-warning">Chưa duyệt</span>
                    @else
                        <span class="badge badge-danger">Từ chối</span>
                    @endif
                </td>
                <td>{{ $member->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>