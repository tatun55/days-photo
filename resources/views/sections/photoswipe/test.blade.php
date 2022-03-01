<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/photoswipe/v5/photoswipe.css') }}" />
</head>

<body>
    <button id="btn-open-pswp-dyn-gen" type="button">Open PhotoSwipe</button>

    <script type="module">
        import PhotoSwipeLightbox from '{{ asset('photoswipe/v5/photoswipe-lightbox.esm.js') }}';

        const options = {
            showHideAnimationType: 'fade',
            pswpModule: '{{ asset('photoswipe/v5/photoswipe.esm.js') }}',
            preload: [1,2,3]
        };

        const lightbox = new PhotoSwipeLightbox(options);

        // total count of items
        lightbox.on('numItems', (e) => {
            e.numItems = 1000;
        });

        // generate data event
        lightbox.on('itemData', (e) => {
            e.itemData = {
                src: 'https://dummyimage.com/100x100/555/fff/?text=' + (e.index + 1),
                srcset: 'https://dummyimage.com/1500x1000/555/fff/?text=1500x1000 1500w, https://dummyimage.com/1200x800/555/fff/?text=1200x800 1200w, https://dummyimage.com/600x400/555/fff/?text=600x400 600w',
                w: 1500,
                h: 1000
            };
        });

        lightbox.init();

        // where to start from
        document.querySelector('#btn-open-pswp-dyn-gen').onclick = (e) => {
            console.log(e);
            lightbox.loadAndOpen(100);
        };
    </script>

</body>

</html>
