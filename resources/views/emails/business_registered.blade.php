<!DOCTYPE html>
<html>

<head>
    <title>{{ $businessData['subject'] }}</title>
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
            <h2>Xác nhận đăng ký doanh nghiệp</h2>
        </div>
        {{-- {{ dd($businessData) }} --}}
        <div class="content">
            <p class="greeting">Xin chào <span class="highlight">{{ $businessData['representative_name'] }}</span>,</p>
            <p>Cảm ơn bạn đã đăng ký tại Gò Vấp E-Business. Chúng tôi xin xác nhận rằng đơn đăng ký của bạn
                đã được tiếp nhận thành công.</p>
            <div class="info-list">
                @php
                    $fields = [
                        'business_name' => 'Tên doanh nghiệp',
                        'business_code' => 'Mã số doanh nghiệp',
                        'business_address' => 'Địa chỉ kinh doanh',
                        'phone_number' => 'Số điện thoại',
                        'fax_number' => 'Số Fax',
                        'email' => 'Email',
                        'address' => 'Địa chỉ',
                        'bank_connection' => 'Kết nối ngân hàng',
                        'purpose' => 'Mục đích',
                        'unsecured_policy' => 'Chính sách vay thế chấp',
                        'mortgage_policy' => 'Tín chấp',
                    ];
                @endphp

                @foreach ($fields as $key => $label)
                    @if (isset($businessData[$key]) && !empty($businessData[$key]))
                        <div class="info-item">
                            <strong>{{ $label }}:</strong> {{ $businessData[$key] }}
                        </div>
                    @endif
                @endforeach

                <div class="info-item">
                    <strong>Tên doanh nghiệp:</strong> {{ $businessData->business_name }}
                </div>
                <div class="info-item">
                    <strong>Mã số doanh nghiệp:</strong> {{ $businessData->business_code}}
                </div>
                <div class="info-item">
                    <strong>Địa chỉ kinh doanh:</strong> {{ $businessData->business_address }}
                </div>
                <div class="info-item">
                    <strong>Số điện thoại:</strong> {{ $businessData->phone_number }}
                </div>
                <div class="info-item">
                    <strong>Số Fax:</strong> {{ $businessData->fax_number }}
                </div>
                <div class="info-item">
                    <strong>Email:</strong> {{ $businessData->email }}
                </div>
                <div class="info-item">
                    <strong>Địa chỉ:</strong> {{ $businessData->address }}
                </div>
                @if (isset($businessData->categoryBusiness) && !empty($businessData->categoryBusines))
                    <div class="info-item">
                        <strong>Loại doanh nghiệp:</strong> {{ $businessData->categoryBusiness->name }}
                    </div>
                @endif

                @if (isset($businessData->ward) && !empty($businessData->ward))
                    <div class="info-item">
                        <strong>Phường:</strong> {{ $businessData->ward->name }}
                    </div>
                @endif

                @if (isset($businessData->field) && !empty($businessData->field))
                    <div class="info-item">
                        <strong>Ngành nghề kinh doanh:</strong> {{ $businessData->field->name }}
                    </div>
                @endif
                @if (isset($businessData->financialSupport) && !empty($businessData->financialSupport))
                    <div class="info-item">
                        <strong>SPKHDN:</strong> {{ $businessData->financialSupport->name }}
                    </div>
                @endif

                @if (isset($businessData->bankServicesInterest) && !empty($businessData->bankServicesInterest))
                    <div class="info-item">
                        <strong>KHCN:</strong> {{ $businessData->bankServicesInterest->name }}
                    </div>
                @endif

            </div>
            <p>Chúng tôi sẽ tiến hành kiểm tra và liên hệ với bạn trong thời gian sớm nhất. Nếu cần thêm thông tin, vui
                lòng liên hệ với chúng tôi qua email</p>
        </div>

        <div class="footer">
            <p>© 2024 Gò Vấp E-Business</p>
        </div>
    </div>
</body>

</html>
