<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            /* Hilangkan scroll bar dari body */
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 92vh;
            /* Buat container setinggi viewport */
        }

        .iframe-container {
            flex: 1;
            /* Ambil sisa ruang dalam container */
            overflow: hidden;
        }

        .iframe-container iframe {
            width: 100%;
            height: 100%;
            /* Pastikan iframe memenuhi container */
            border: 0;
        }
    </style>

    <div class="container">
        <h2 class="text-center">{{ $title }}</h2>

        <div class="iframe-container">
            <iframe src="http://192.168.0.251:3000/public/dashboard/2eb11447-9197-4c9b-bfaa-f0246c64c0d6" allowtransparency></iframe>
        </div>

    </div>
</div>