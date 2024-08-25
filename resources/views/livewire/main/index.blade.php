<div>
    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <style>
    .iframe-container {
        display: block;
        flex-direction: column;
        height: 87vh;
        width: 100%;
        flex: 1;
        overflow: hidden;
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    .carousel-item {
        position: relative;
        height: 90vh;
        gan tinggi layar */
    }

    .carousel-item img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-height: 100%;
        max-width: 100%;
        height: auto;
    }

    @media only screen and (max-width: 767px) {
        .smaller-image {
            width: 50%;
        }

        .iframe-container {
            height: 77vh;
            width: 100%;
        }
    }

    @media only screen and (orientation: landscape) {
        .iframe-container {
            height: 79vh;
            width: auto !important;
        }

        .smaller-image {
            width: 35%;
        }
    }
    </style>

    @if (in_array((auth()->user()->roles ?? ''), ['SUPERVISOR']))

    <div class="card">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="iframe-container">
                        <iframe
                            src="https://mb.dinastysinghasarigroup.com/public/dashboard/b6ab28cc-3819-42b1-9566-4aa61e6b6b60"
                            frameborder="1"
                            titled=false
                            allowtransparency></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div id="carouselExampleSlidesOnly"
        class="carousel slide"
        data-bs-ride="carousel"
        data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/directselling.jpg') }}"
                    class="img-fluid responsive rounded-top rounded-bottom shadow shadow-custom smaller-image"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/directselling-panel.jpg') }}"
                    class="img-fluid responsive rounded-top rounded-bottom shadow shadow-custom smaller-image"
                    alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/dinasty.jpg') }}"
                    class="img-fluid responsive rounded-top rounded-bottom shadow shadow-custom smaller-image"
                    alt="...">
            </div>
        </div>
    </div>
    @endif

</div>