<!DOCTYPE html>
<html>

<head>
    <title>{{ $businessCapitalNeed->subject }}</title>
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
            <h2>{{ $businessCapitalNeed->subject }}</h2>
        </div>
        <div class="content">

            <p class="">Có {{ $businessCapitalNeed->subject }} mới</p>
            <div class="info-list">
                <div class="info-item">
                    <strong>Số vốn đăng ký:</strong> {{ number_format($businessCapitalNeed->finance, 0, ',', '.') }} ₫
                </div>
                <div class="info-item">
                    <strong>Chu kỳ vay:</strong> {{ $businessCapitalNeed->loan_cycle }} tháng
                </div>
                <div class="info-item">
                    <strong>Lãi suất đề xuất:</strong> {{ $businessCapitalNeed->interest_rate }}%
                </div>
                <div class="info-item">
                    <strong>Mục đích vay vốn:</strong> {{ $businessCapitalNeed->purpose }}
                </div>
                <div class="info-item">
                    <strong>Ngân hàng kết nối:</strong> {{ $businessCapitalNeed->bank_connection }}
                </div>
                <div class="info-item">
                    <strong>Chính sách hỗ trợ:</strong> {{ $businessCapitalNeed->support_policy }}
                </div>
                @if ($businessCapitalNeed->feedback)
                    <div class="info-item">
                        <strong>Phản hồi:</strong> {{ $businessCapitalNeed->feedback }}
                    </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p>© 2024 Gò Vấp E-Business</p>
        </div>
    </div>
</body>

</html>