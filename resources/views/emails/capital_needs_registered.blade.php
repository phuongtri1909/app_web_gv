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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
            .content, .info-list {
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

        <div class="content">
            <p class="greeting">Xin chào <span class="highlight">{{ $businessData['representative_name'] }}</span>,</p>
            <p>Cảm ơn bạn đã đăng ký doanh nghiệp tại Gò Vấp E-Business. Chúng tôi xin xác nhận rằng đơn đăng ký của bạn đã được tiếp nhận thành công.</p>

            <div class="info-list">
            <div class="info-list">
                <div class="info-item"><strong>MST:</strong> {{ $businessData['business_code'] }}</div>
                <div class="info-item"><strong>Tên doanh nghiệp:</strong> {{ $businessData['business_name'] }}</div>
                <div class="info-item"><strong>Số điện thoại:</strong> {{ $businessData['phone_number'] }}</div>
                <div class="info-item"><strong>Địa chỉ kinh doanh:</strong> {{ $businessData['business_address'] }}</div>
                <div class="info-item"><strong>Phường:</strong> {{ $businessData['ward_id'] }}</div>
                <div class="info-item"><strong>Email doanh nghiệp:</strong> {{ $businessData['email'] }}</div>
                <div class="info-item"><strong>Loại doanh nghiệp:</strong> {{ $businessData['category_business_id '] }}</div>
                <div class="info-item"><strong>Ngành nghề kinh doanh:</strong> {{ $businessData['business_fields '] }}</div>
                <div class="info-item"><strong>Địa chỉ cư trú:</strong> {{ $businessData['address'] }}</div>
            </div>

            <p>Chúng tôi sẽ tiến hành kiểm tra và liên hệ với bạn trong thời gian sớm nhất. Nếu cần thêm thông tin, vui lòng liên hệ với chúng tôi qua email</p>
        </div>

        <div class="footer">
            <p>© 2024 Gò Vấp E-Business</p>
        </div>
    </div>
</body>
</html>
