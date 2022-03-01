<script type="module">
    import PhotoSwipeLightbox from '{{ asset('photoswipe/v5/photoswipe-lightbox.esm.js') }}';

    const items = @json($items);
    const url = 'https://days-photo.s3.ap-northeast-1.amazonaws.com';
    const options = {
        showHideAnimationType: 'fade',
        pswpModule: '{{ asset('photoswipe/v5/photoswipe.esm.js') }}',
        preload: [1,2]
    };
    const lightbox = new PhotoSwipeLightbox(options);

    // total count of items
    lightbox.on('numItems', (e) => {
        e.numItems = Object.keys(items).length;
    });

    // generate data event
    lightbox.on('itemData', (e) => {
        let index = e.index + 1;
        let id = items[index].id;
        let width = items[index]["width"];
        let height = items[index]["height"];
        e.itemData = {
            src: `${url}/l/${id}.jpg`, // biggest size one
            srcset: `${url}/l/${id}.jpg 1600w, ${url}/m/${id}.jpg 960w`,
            w: width,
            h: height
        }
    });

    lightbox.init();

    document.querySelectorAll('.item').forEach(elem => {
        elem.addEventListener('click', e => {
            let i = e.target.getAttribute('data-index') - 1;
            lightbox.loadAndOpen(i);
        });
    });

</script>
