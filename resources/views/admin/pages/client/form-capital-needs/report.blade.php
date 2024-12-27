<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên doanh nghiệp</th>
            <th>Mã doanh nghiệp</th>
            <th>SĐT Zalo</th>
            <th>Ngành nghề</th>
            <th>Trạng thái</th>
            <th>Ngày đăng ký</th>
            <th>Số vốn đăng ký</th>
            <th>Chu kỳ vay</th>
            <th>Đề xuất lãi xuất</th>
            <th>Mục đích vay vốn</th>
            <th>Đề nghị kết nối ngân hàng</th>
            <th>Đề xuất chính sách của ngân hàng</th>
            <th>Ý kiến</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($CapitalNeeds as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->businessMember->business_name }}</td>
                <td>{{ $item->businessMember->business_code }}</td>
                <td>{{ $item->businessMember->phone_zalo }}</td>
                <td>
                    @if ($item->business_fields)
                        <span class="badge badge-primary">{{ implode(', ', $item->business_fields) }}</span>
                    @endif
                </td>
                <td>
                    @if ($item->email_status == 'sent')
                        <span class="badge badge-success">Đã gửi mail cho ngân hàng</span>
                    @else
                        <span class="badge badge-danger">Chưa gửi</span>
                    @endif
                </td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->finance ?? '-' }}</td>
                <td>{{ $item->loan_cycle ?? '-' }}</td>
                <td>{{ $item->interest_rate ?? '-' }}</td>
                <td>{{ $item->purpose ?? '-' }}</td>
                <td>{{ $item->bank_connection ?? '-' }}</td>
                <td>{{ $item->support_policy ?? '-' }}</td>
                <td>{{ $item->feedback ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>