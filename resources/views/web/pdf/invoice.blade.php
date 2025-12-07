<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <title>التوكيل | فاتورة</title>

    <style>
        @page {
            margin: 20px 25px;
        }

        html,
        body {
            direction: rtl;
            unicode-bidi: embed;
            font-family: 'dubai', sans-serif;
        }

        * {
            letter-spacing: 0;
            font-variant-ligatures: normal;
        }

        .text-right {
            text-align: right;
        }

        .invoice {
            border: 1px solid #eee;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        thead th {
            background: #4C4C4C;
            color: #fff;
        }

        .text-center {
            text-align: center;
        }

        .text-red-600 {
            color: #dc2626;
        }

        .text-green-600 {
            color: #16a34a;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-lg {
            font-size: 18px;
        }

        .my-8 {
            margin: 24px 0;
        }

        .mt-6 {
            margin-top: 16px;
        }

        .mt-8 {
            margin-top: 24px;
        }

        .p-8 {
            padding: 16px;
        }

        .px-12 {
            padding: 0 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .flex {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .justify-between {
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <main>
        <div class="invoice">
            <img src="{{ public_path('frontend/img/invoice/header.png') }}" alt="Logo"
                style="width:100%; height:auto;">
            <h2 class="text-center text-red-600 font-bold text-lg my-8">فاتورة حجز سيارة</h2>

            <div class="grid px-12">
                <p><span class="font-bold">رقم الفاتورة:</span> {{ $invoiceNumber }}</p>
                <p><span class="font-bold">رقم الطلب:</span> {{ $order->id }}</p>
                <p><span class="font-bold">رقم العملية:</span> {{ $order->provider_transaction_reference ?? '-' }}</p>
                <p><span class="font-bold">تاريخ الإصدار:</span> {{ $issueDate }}</p>
                <p><span class="font-bold">العميل:</span> {{ $order->display_customer_name }}</p>
                <p><span class="font-bold">سعر السيارة:</span> <span
                        class="text-red-600">{{ number_format($order->price) }}</span> جنيه مصري</p>
                <p><span class="font-bold">الفرع المختار:</span> {{ $order->term->model->brand->name ?? '-' }} - {{ $order->branch->city_name ?? '-' }} - {{ $order->branch_name ?? '-' }}</p>
                <p><span class="font-bold">عنوان الفرع:</span> {{ $order->branch->address ?? '-' }}</p>
                <p><span class="font-bold">رقم تليفون الفرع:</span> {{ $order->branch->phone ?? '-' }}</p>
            </div>

            <div class="mt-6">
                <table class="text-center">
                    <thead>
                        <tr>
                            <th>بند</th>
                            <th>سعر الحجز</th>
                            <th>الكمية</th>
                            <th>الوصف</th>
                            <th>لون 1</th>
                            <th>لون 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ number_format($order->reservation_amount) }}</td>
                            <td>1</td>
                            <td>{{ $order->term->model->brand->name }} {{ $order->term->model->name }}
                                {{ $order->term->term_name }}</td>
                            <td>{{ $firstColorName }}</td>
                            <td>{{ $secondColorName }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-8">
                <p class="font-bold">تم دفع مبلغ الحجز - نظام  {{ $paymentLabel }}</p>
                <p class="text-green-600 font-bold text-lg">{{ number_format($order->reservation_amount) }} جنيه مصري
                </p>
            </div>

            <div style="background:#4C4C4C; color:#fff;" class="text-xs mt-8 p-8 text-center flex justify-between">
                <p class="m-0 flex">رقم السجل التجاري: 27364</p>
                <p class="m-0 flex">رقم البطاقة الضريبية: 12346</p>
                <a class="m-0 flex"
                    href="https://www.google.com/maps/place/Icon+Creations/@29.9560779,31.2314096,13z/data=!4m6!3m5!1s0x145840ccc0b96085:0x87f0364e359c5fe7!8m2!3d29.95608!4d31.2600436!16s%2Fg%2F11cffgqjc?authuser=0&entry=tts&g_ep=EgoyMDI1MDgyNS4wIPu8ASoASAFQAw%3D%3D&skid=807d0405-1616-44b8-b004-67bdfbf1ba9f"
                    target="_blank" style="color: white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14"
                        fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5 0.875C3.83968 0.875 2.72688 1.33594 1.90641 2.15641C1.08594 2.97688 0.625 4.08968 0.625 5.25C0.625 6.2475 1.115 7.427 1.82987 8.69225C2.5535 9.97237 3.551 11.4109 4.64388 12.9421L5 13.4409L5.35612 12.9421C6.44987 11.4109 7.4465 9.97237 8.17013 8.69225C8.885 7.427 9.375 6.2475 9.375 5.25C9.375 4.67547 9.26184 4.10656 9.04197 3.57576C8.82211 3.04496 8.49985 2.56266 8.09359 2.15641C7.68734 1.75015 7.20504 1.42789 6.67424 1.20803C6.14344 0.988163 5.57453 0.875 5 0.875ZM5 3.0625C4.41984 3.0625 3.86344 3.29297 3.4532 3.7032C3.04297 4.11344 2.8125 4.66984 2.8125 5.25C2.8125 5.83016 3.04297 6.38656 3.4532 6.7968C3.86344 7.20703 4.41984 7.4375 5 7.4375C5.58016 7.4375 6.13656 7.20703 6.5468 6.7968C6.95703 6.38656 7.1875 5.83016 7.1875 5.25C7.1875 4.66984 6.95703 4.11344 6.5468 3.7032C6.13656 3.29297 5.58016 3.0625 5 3.0625Z"
                            fill="white" />
                    </svg>
                    28 شارع 7 - المعادي القاهرة - مصر
                </a>
                <a class="m-0 flex" href="mailto:info@eltawkeel.com" style="color: white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                        fill="none">
                        <path
                            d="M12.0315 2.82812H1.96722C1.87233 2.82827 1.78138 2.86604 1.7143 2.93315C1.64722 3.00025 1.60949 3.09122 1.60938 3.18611V3.90626C1.60938 3.93944 1.64536 3.97753 1.67476 3.99293L6.9648 7.01454C6.97835 7.02229 6.99371 7.0263 7.00932 7.02616C7.02527 7.02624 7.04095 7.02198 7.05468 7.01384L12.1848 3.99587C12.2137 3.97977 12.2901 3.93721 12.3188 3.91761C12.3535 3.89395 12.3894 3.87253 12.3894 3.83011V3.18597C12.3892 3.09111 12.3515 3.00017 12.2844 2.9331C12.2173 2.86602 12.1264 2.82827 12.0315 2.82812ZM12.3447 4.9921C12.331 4.98419 12.3154 4.98008 12.2995 4.98018C12.2836 4.98028 12.2681 4.98459 12.2544 4.99267L9.35124 6.7008C9.33967 6.70755 9.32977 6.7168 9.32226 6.7279C9.31476 6.73899 9.30986 6.75162 9.30791 6.76487C9.30596 6.77812 9.30701 6.79163 9.311 6.80441C9.31499 6.8172 9.3218 6.82892 9.33094 6.8387L12.2345 9.96868C12.2428 9.97774 12.253 9.98495 12.2642 9.98987C12.2755 9.99479 12.2876 9.9973 12.2999 9.99724C12.3236 9.99721 12.3464 9.98777 12.3631 9.971C12.3799 9.95423 12.3893 9.9315 12.3894 9.90778V5.0698C12.3894 5.05407 12.3853 5.03861 12.3775 5.02497C12.3696 5.01133 12.3583 5 12.3447 4.9921ZM8.5146 7.27438C8.50082 7.25938 8.4823 7.24955 8.46215 7.24654C8.44199 7.24353 8.42142 7.24753 8.40386 7.25786L7.24018 7.9426C7.17201 7.98204 7.09475 8.00305 7.01601 8.00356C6.93726 8.00408 6.85973 7.98408 6.79106 7.94554L5.76696 7.36048C5.75042 7.35107 5.73132 7.34716 5.71242 7.34932C5.69352 7.35149 5.67579 7.35961 5.66182 7.37252L1.7729 10.9798C1.7627 10.9893 1.75487 11.0011 1.75004 11.0142C1.7452 11.0273 1.74349 11.0413 1.74504 11.0552C1.74659 11.069 1.75136 11.0824 1.75897 11.0941C1.76657 11.1058 1.77681 11.1155 1.78886 11.1226C1.84934 11.1581 1.90772 11.1751 1.96708 11.1751H11.9285C11.9459 11.175 11.9629 11.1699 11.9775 11.1603C11.992 11.1507 12.0035 11.1371 12.0104 11.1212C12.0173 11.1052 12.0194 11.0876 12.0165 11.0705C12.0135 11.0534 12.0057 11.0374 11.9939 11.0247L8.5146 7.27438ZM4.80614 6.94581C4.81641 6.93627 4.8243 6.92445 4.82918 6.91131C4.83405 6.89817 4.83578 6.88406 4.83421 6.87013C4.83264 6.8562 4.82783 6.84284 4.82016 6.8311C4.81249 6.81937 4.80217 6.8096 4.79004 6.80258L1.7428 5.0621C1.7292 5.05438 1.71381 5.05037 1.69817 5.05046C1.68253 5.05055 1.66719 5.05475 1.65369 5.06263C1.64018 5.07051 1.62898 5.0818 1.6212 5.09537C1.61342 5.10893 1.60935 5.12431 1.60938 5.13994V9.70674C1.60928 9.72419 1.6143 9.74127 1.62381 9.75589C1.63332 9.77051 1.64691 9.78202 1.6629 9.78899C1.67889 9.79597 1.69657 9.7981 1.71376 9.79512C1.73094 9.79215 1.74688 9.7842 1.7596 9.77226L4.80614 6.94581Z"
                            fill="white" />
                    </svg>
                    info@eltawkeel.com
                </a>
            </div>
        </div>
    </main>
</body>

</html>
