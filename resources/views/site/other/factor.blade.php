<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاکتور {{ $info->description }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://v1.fontapi.ir/css/VazirFD');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Vazir FD', sans-serif;
            background-color: #f5f7fa;
        }

        .invoice-container {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .header-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .divider {
            border-top: 2px dashed #e2e8f0;
        }

        .package-card {
            transition: all 0.3s ease;
            border-left: 4px solid #4f46e5;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .badge {
            top: -10px;
            right: -10px;
        }

        .watermark {
            opacity: 0.05;
            z-index: 0;
        }

        @media print {
            body {
                font-size: 12px;
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .header-gradient {
                padding: 10px !important;
            }

            .p-6 {
                padding: 10px !important;
            }

            .text-2xl {
                font-size: 1.2rem !important;
            }

            .text-xl {
                font-size: 1.1rem !important;
            }

            .mt-6,
            .my-6 {
                margin-top: 10px !important;
            }

            .mt-4 {
                margin-top: 8px !important;
            }

            .mt-2 {
                margin-top: 5px !important;
            }

            .divider {
                margin: 8px 0 !important;
            }

            .watermark {
                display: none;
            }

            .max-w-4xl {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .invoice-container.bg-white.mt-6 {
                display: none;
            }

            .shadow-sm {
                box-shadow: none !important;
            }

            .flex.justify-center.space-x-4.space-x-reverse {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50 py-4 px-2 print:py-0 print:px-0">
    <div class="max-w-4xl mx-auto print:mx-0">
        <div class="invoice-container bg-white">
            <!-- Header -->
            <div class="header-gradient text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">فاکتور خرید</h1>
                        <p class="text-indigo-100 mt-1">{{ $info->description }}</p>
                    </div>
                    <div class="text-left">
                        <p class="text-indigo-200">شماره فاکتور: <span
                                class="font-bold">INV-{{ $info->invoice_number }}</span>
                        </p>
                        <p class="text-indigo-200 mt-1">تاریخ: <span
                                class="font-bold">{{ jdate($info->created_at)->format('Y/m/d') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Company Info -->
            <div class="p-6 border-b">
                <div class="flex justify-between">
                    <div class="text-gray-700" style="width: 70%">
                        <h2 class="text-lg font-bold text-gray-800">{{ get_setting('company_name') }}</h2>
                        <p class="mt-1" style="line-height: 1.7; margin-bottom: 14px;"><i
                                class="fas fa-map-marker-alt ml-2 text-indigo-500"></i>
                            {{ get_setting('company_address') }}</p>
                        <p class="mt-1"><i class="fas fa-phone ml-2 text-indigo-500"></i>
                            {{ get_setting('company_phone') }}</p>
                        <p class="mt-1"><i class="fas fa-envelope ml-2 text-indigo-500"></i>
                            {{ get_setting('company_email') }}</p>
                    </div>
                    <div class="text-left" style="width: 30%">
                        <div class="rounded-lg inline-block">
                            <img src="{{ asset('admin/img/logo.webp') }}" alt="Logo" class=""
                                style="height: auto;width: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="p-6 border-b">
                <h3 class="text-lg font-bold text-gray-800 mb-4">اطلاعات مشتری</h3>
                <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-gray-600">نام مشتری:</p>
                        <p class="font-bold">
                            {{ $info->user->document->first_name . ' ' . $info->user->document->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">شماره همراه:</p>
                        <p class="font-bold">{{ $info->user->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">کد ملی:</p>
                        <p class="font-bold">{{ $info->user->document->national_id }}</p>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">جزئیات کالا / خدمات خریداری شده</h3>

                <div class="package-card bg-white px-5 rounded-lg  relative mb-6">

                    <div class="flex justify-between items-center">
                        <div>
                            @if ($info->type != 'wallet_topup')
                                <h4 class="text-xl font-bold text-indigo-700">
                                    {{ $info->subscription->subscription->name }}</h4>

                                <p class="text-gray-600 mt-2"><i class="fas fa-dollar ml-2 text-indigo-500"></i> مبلغ :
                                    {{ number_format($info->amount + $info->discount_amount) }} ریال</p>
                                <p class="text-gray-600 mt-1"><i class="far fa-calendar-alt ml-2 text-indigo-500"></i>
                                    اعتبار: {{ $info->subscription->subscription->duration_days }} روز</p>
                            @else
                                <h4 class="text-xl font-bold text-indigo-700">{{ $info->description }}</h4>
                                <p class="text-gray-600 mt-2"><i class="fas fa-dollar ml-2 text-indigo-500"></i> مبلغ :
                                    {{ number_format($info->amount) }} ریال</p>
                            @endif
                        </div>
                        <div class="text-left">
                            @if ($info->discount_amount > 0)
                                <p class="text-gray-500 line-through mb-1">
                                    {{ number_format($info->amount + $info->discount_amount) }} ریال
                                </p>
                                <p class="text-2xl font-bold text-indigo-600">
                                    {{ number_format($info->amount) }} ریال
                                </p>
                                <p class="text-green-600 text-sm mt-1">
                                    {{ discountPercentCalculation($info->amount, $info->discount_amount) }}%
                                    تخفیف
                                </p>
                            @else
                                <p class="text-2xl font-bold text-indigo-600">
                                    {{ number_format($info->amount) }} ریال
                                </p>
                                <p class="text-gray-400 text-sm mt-1">بدون تخفیف</p>
                            @endif
                        </div>


                        {{-- <div class="text-left">
                            <p class="text-gray-500 line-through mb-1">
                                {{ number_format($info->amount + $info->discount_amount) }}
                                ریال</p>
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($info->amount) }} ریال</p>
                            <p class="text-green-600 text-sm mt-1">
                                {{ discountPercentCalculation($info->amount, $info->discount_amount) }}% تخفیف</p>
                        </div> --}}
                    </div>
                </div>

                <div class="divider my-6"></div>

                <!-- Payment Summary -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">روش پرداخت:</p>
                        @switch($info->type)
                            @case('subscription_wallet')
                                <p class="font-bold"><i class="far fa-credit-card ml-2 text-indigo-500"></i> پرداخت از طریق کیف
                                    پول</p>
                            @break

                            @case('subscription_direct')
                                <p class="font-bold"><i class="far fa-credit-card ml-2 text-indigo-500"></i> پرداخت آنلاین
                                    (درگاه زرین پال)</p>
                            @break

                            @case('wallet_topup')
                                <p class="font-bold"><i class="far fa-credit-card ml-2 text-indigo-500"></i> پرداخت آنلاین
                                    (درگاه زرین پال)</p>
                            @break

                            @default
                        @endswitch
                    </div>
                    {{-- <div class="text-left">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600">مبلغ کل:</p>
                            <p class="text-2xl font-bold text-indigo-600">۲۴۹,۰۰۰ تومان</p>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-6 text-center text-gray-600 text-sm">
                <div class="relative">
                    <div class="watermark absolute inset-0 flex items-center justify-center">
                        <span class="text-6xl font-bold text-indigo-200">پرداخت شده</span>
                    </div>
                    <div class="relative z-10">
                        <p>با تشکر از اعتماد شما</p>
                        <p class="mt-2">این فاکتور به منزله رسید پرداخت می باشد</p>
                        <div class="mt-4 flex justify-center space-x-4 space-x-reverse">
                            <a href="#" class="text-indigo-500 hover:text-indigo-700"><i
                                    class="fas fa-print ml-1"></i> چاپ فاکتور</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
        // Simple script for print functionality
        document.addEventListener('DOMContentLoaded', function() {
            const printBtn = document.querySelector('a[href="#"]:first-of-type');
            printBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.print();
            });

            // You can add more functionality for download and share buttons
        });
    </script>
</body>

</html>
