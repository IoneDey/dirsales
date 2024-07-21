<div>
    <link href="{{ asset('css/styles_table_res.css') }}" rel="stylesheet" />
    <style>
        @page {
            size: A5;
            margin: 0;
            border: 10px solid black;
        }

        body {
            font-family: Arial, sans-serif;
            width: 21cm;
            height: 14.8cm;
            margin: 0;
            padding: 2px;
        }

        .header {
            text-align: center;
        }

        @media print {
            body {
                width: auto;
                height: auto;
                margin: 0 !important;
                padding: 0 !important;
            }
        }

        .customer {
            display: flex;
            justify-content: space-between;
            padding: 5px 10px;
            font-size: 12px;
        }

        .left {
            flex: 1;
        }

        .right {
            flex-shrink: 0;
        }

        /* Table full border */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .table th,
        .table td {
            border: 0.5px solid black;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .table tfoot td {
            border: none !important;
        }

        .notes {
            font-size: 12px;
            margin-top: 10px;
            padding: 0 10px;
            text-align: justify;
            font-weight: bold;
        }

        .barcode-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #barcode {
            max-width: 100%;
            height: auto;
        }

        .element-with-border {
            border-bottom: 7px solid darkred;
            /* Opsional: untuk memberikan ruang di bawah garis */
        }

        /* kop */
        .displaycustom {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            margin-top: 0;
            background-color: #c0c0c0;
            padding: 10px;
        }

        .bordercustom {
            border: none;
            padding: 5px;
            margin-top: 0px;
            width: 100%;
        }

        .logo-container {
            flex-shrink: 0;
        }

        .logo {
            width: 90px;
            height: auto;
        }

        .content {
            flex-grow: 1;
        }

        .text {
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.4;
        }

        .labels {
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.4;
            display: grid;
            grid-template-columns: auto auto;
            gap: 0px;
            align-items: start;
        }

        .label {
            font-family: Arial, sans-serif;
            font-size: 8px;
            line-height: 1.4;
        }

        .label-text {
            margin-left: 0px;
        }
    </style>


    <div class="container bordercustom">
        <div class="element-with-border"></div>

        <div class="displaycustom bordercustom">
            <div class="logo-container">
                <img src="{{ asset('img/logodinastysinghasarigroup.png') }}" class="logo" alt="DINASTY SINGHASARI GROUP">
            </div>
            <div class="content">
                <div class="text mt-2">
                    <span>PT. DINASTY SINGHASARI GROUP</span><br>
                    <span>Kantor : Jl. Raya Randuagung 246</span><br>
                    <span>Singosari - Malang</span><br>
                    <span>Jawa Timur - Indonesia</span>
                </div>
            </div>
            <div class="labels mt-2">
                <div class="label">
                    <span>Halaman </span>
                </div>
                <div class="label-text">
                    : 1
                </div>
                <div class="label">
                    <span>Tanggal </span>
                </div>
                <div class="label-text">
                    : 22 Jun 2024
                </div>
            </div>
        </div>

        <div class="container">
            <div class="customer">
                <div class="left">Ditujukan Kepada : {{ $namacustomer }}</div>
                <div class="right">Tanggal: {{ $tgljual }}</div>
            </div>

            <table class="table table-sm">
                <thead>
                    <tr>
                        <th class="rata-tengah">No</th>
                        <th class="rata-tengah">Nama Barang</th>
                        <th class="rata-tengah">Qty</th>
                        <th class="rata-tengah">@if($model=="invoice") Harga @endif @if($model=="suratjalan") Unit @endif</th>
                        @if($model=="invoice")
                        <th class="rata-tengah">Total</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $item)
                    <tr>
                        <td class="rata-tengah">{{ $loop->iteration }}</td>
                        <td>{{ $item->NamaBarang }}</td>
                        <td class="rata-tengah">{{ $item->Qty }}</td>
                        <td class="rata-kanan">@if($model=="invoice") {{ number_format(($item->Harga ?? 0), 0, ',', '.') }} @endif @if($model=="suratjalan") Dus @endif</td>
                        @if($model=="invoice")
                        <td class="rata-kanan">{{ number_format(($item->Total ?? 0), 0, ',', '.') }}</td>
                        @endif
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="rata-tengah">{{ number_format(($totalqty ?? 0), 0, ',', '.') }}</td>
                        <td></td>
                        @if($model=="invoice")
                        <td class="rata-kanan">Rp. {{ number_format(($grandtotal ?? 0), 0, ',', '.') }}</td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="notes">
            Faktur Penjualan ini dibuat sesuai dengan perjanjian kedua belah pihak, dan telah disetujui bersama. Faktur ini dibuat
            untuk dilakukan penagihan sesuai tanggal jatuh tempo dan dianggap lunas ketika sudah dibayar secara tunai atau
            transaksi ke bank.
        </div>

        <div class="barcode-container">
            <img id="barcode" src="{{ $qrCodeBase64 }}" />
        </div>

        <div class="customer">
            Tanda Tangan
            <div class="left">

                <u>
                    <pre>                 </pre>
                </u>
            </div>
            Tanggal
            <div class="right">

                <u>
                    <pre>               </pre>
                </u>
            </div>
        </div>

        <div class="element-with-border"></div>
    </div>

    <script type="text/javascript">
        function printAndClose() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        }
        window.onload = printAndClose;
    </script>
</div>