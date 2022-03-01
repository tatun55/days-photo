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

    // custumize button
    lightbox.on('uiRegister', function() {
        let nextBtnElem = {
            name: 'next-button',
            order: 9,
            isButton: true,
            html:`<button class="btn btn-link inline-block me-auto"><span class="fas fa-angle-right text-white h3 m-0 me-6"></span></button>`,
            onClick: (event, el) => {
                lightbox.pswp.next();
            }
        };
        let prevBtnElem = {
            name: 'prev-button',
            order: 5,
            isButton: true,
            html:`<button class="btn btn-link inline-block me-auto"><span class="fas fa-angle-left text-white h3 m-0 ms-4"></span></button>`,
            onClick: (event, el) => {
                lightbox.pswp.prev();
            }
        };
        lightbox.pswp.ui.registerElement(nextBtnElem);
        lightbox.pswp.ui.registerElement(prevBtnElem);
    });

    lightbox.init();


    var slideShowEvent = function (e) {
        let i = e.target.getAttribute('data-index') - 1;
        lightbox.loadAndOpen(i);
    };
    
    function addSlideShowEvents() {
        document.querySelectorAll('.item').forEach(elem => {
            elem.addEventListener('click', slideShowEvent, false);
        });
    }

    function removeSlideShowEvents() {
        document.querySelectorAll('.item').forEach(elem => {
            elem.removeEventListener('click', slideShowEvent, false);
        });
    }

    addSlideShowEvents();

    // item-menus
    const selectBtn = document.querySelector('#select-btn');
    const selectDesc = document.querySelector('#select-desc');
    const cancelBtn = document.querySelector('#cancel-btn');
    const moveBtn = document.querySelector('#move-btn');
    const archiveBtn = document.querySelector('#archive-btn');
    selectBtn.onclick = () => {
        selectMode();
    };
    cancelBtn.onclick = () => {
        normalMode();
        addSlideShowEvents();
    };

    function selectMode() {
        console.log('select mode');
        selectBtn.classList.toggle('show');
        selectDesc.classList.toggle('show');
        cancelBtn.classList.toggle('show');
        removeSlideShowEvents();
        // moveBtn.classList.toggle('show');
        // archiveBtn.classList.toggle('show');
    }

    function normalMode() {
        console.log('normal mode');
        selectBtn.classList.toggle('show');
        selectDesc.classList.toggle('show');
        cancelBtn.classList.toggle('show');
    }
</script>
