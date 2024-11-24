<!DOCTYPE html>
<html>

<head>
    <title>{{ $businessMember->subject }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        .container {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #004aad;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
        }

        .greeting {
            font-size: 15px;
            color: #333;
        }

        .info-list {
            background: #f9fbfd;
            border: 1px solid #e1e7ef;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .info-item {
            padding: 8px 0;
            border-bottom: 1px solid #e1e7ef;
            color: #555;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .highlight {
            color: #004aad;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #666;
            background: #f4f6f9;
        }

        .footer p {
            margin: 0;
            line-height: 1.5;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .content,
            .info-list {
                padding: 15px;
            }

            .header h2 {
                font-size: 18px;
            }

            .greeting {
                font-size: 14px;
            }

            .footer {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Đăng ký tham gia app</h2>
        </div>
        <div class="content">

            <p class="">Có đăng ký tham gia app mới</p>
            <div class="info-list">
                @php
                    $fields = [
                        'business_name' => 'Tên doanh nghiệp',
                        'business_code' => 'Mã số doanh nghiệp',
                        'address' => 'Địa chỉ kinh doanh',
                        'email' => 'Email',
                        'phone_zalo' => 'Số điện thoại zalo',
                        'business_field' => 'Ngành nghề kinh doanh',
                        'representative_full_name' => 'Người đại diện',
                        'representative_phone' => 'Số điện thoại liên hệ',
                    ];
                @endphp

                @foreach ($fields as $key => $label)
                    @if (isset($businessMember->$key) && !empty($businessMember->$key))
                        <div class="info-item">
                            @if ($key == 'business_field')
                                <strong>{{ $label }}:</strong> {{ $businessMember->businessField->name }}
                            @else
                                <strong>{{ $label }}:</strong> {{ $businessMember->$key }}
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="footer">
            <p>© 2024 Gò Vấp E-Business</p>
        </div>
    </div>
</body>

</html>
