<script type="module">
    import PhotoSwipeLightbox from '{{ asset('photoswipe/v5/photoswipe-lightbox.esm.js') }}';

const dataSource=@json($dataSource);
const url='https://days-photo.s3.ap-northeast-1.amazonaws.com';

const options= {
    showHideAnimationType: 'fade',
    pswpModule: '{{ asset('photoswipe/v5/photoswipe.esm.js') }}',
    preload: [1, 2],
    dataSource: dataSource
};
const lightbox=new PhotoSwipeLightbox(options);

// total count of items
// lightbox.on('numItems', (e)=> {
//     e.numItems=Object.keys(items).length;
// });

// generate data event
// lightbox.on('itemData', (e) => {
//     let index = e.index + 1;
//     let id = items[index].id;
//     let width = items[index]["width"];
//     let height = items[index]["height"];
//     e.itemData = {
//         src: `${url}/l/${id}.jpg`, // biggest size one
//         srcset: `${url}/l/${id}.jpg 1920w, ${url}/m/${id}.jpg 960w`,
//         w: width,
//         h: height
//     };
// });

// custumize button
lightbox.on('uiRegister', function() {
        let nextBtnElem= {
            name: 'next-button',
            order: 9,
            isButton: true,
            html:`<a class="text-default inline-block"><span class="slideshow-menu-btn-icon fas fa-angle-right text-white m-0 me-6"></span></a>`,
            onClick: (event, el)=> {
                lightbox.pswp.next();
            }
        };

        let prevBtnElem= {
            name: 'prev-button',
            order: 5,
            isButton: true,
            html:`<a class="text-default inline-block"><span class="slideshow-menu-btn-icon fas fa-angle-left text-white m-0 ms-4"></span></a>`,
            onClick: (event, el)=> {
                lightbox.pswp.prev();
            }
        };
        lightbox.pswp.ui.registerElement(nextBtnElem);
        lightbox.pswp.ui.registerElement(prevBtnElem);
    }
);

lightbox.init();


var slideShowEvent=function (e) {
    let i = e.target.querySelector('img').getAttribute('data-index') - 1;
    lightbox.loadAndOpen(i);
};

function addSlideShowEvents() {
    document.querySelectorAll('.item').forEach(elem=> {
        elem.addEventListener('click', slideShowEvent, false);
    });
}

function removeSlideShowEvents() {
    document.querySelectorAll('.item').forEach(elem=> {
        elem.removeEventListener('click', slideShowEvent, false);
    });
}

addSlideShowEvents();

// item-menus
const selectBtn=document.querySelector('#select-btn');
const selectDesc=document.querySelector('#select-desc');
const cancelBtn=document.querySelector('#cancel-btn');
const moveBtn=document.querySelector('#move-btn');
const archiveBtn=document.querySelector('#archive-btn');

selectBtn.onclick=()=> {
    selectMode();
};

cancelBtn.onclick=()=> {
    normalMode();
    addSlideShowEvents();
};

function selectMode() {
    console.log('select mode');
    selectBtn.classList.remove('show');
    selectDesc.classList.add('show');
    cancelBtn.classList.add('show');
    removeSlideShowEvents();
    document.querySelectorAll('form#items-form input[name="items[]"]').forEach(elem=> {
        // var itemIndex=elem.querySelector('img').getAttribute('data-index');
        // var checkbox=document.createElement('input');
        // checkbox.name='items';
        // checkbox.type='checkbox';
        // checkbox.value=itemIndex;
        // checkbox.classList.add('hidden-checkbox');
        // elem.prepend(checkbox);
        elem.removeAttribute('disabled');
        elem.addEventListener("change", isAnyCheckboxChecked, false);
    });
}

function isAnyCheckboxChecked() {
    var flag = false;
    var itemInputs=document.querySelectorAll('form#items-form input[name="items[]"]');
    for(let itemInput of itemInputs) {
        if(itemInput.checked) {
            console.log('there is checked one.');
            if(selectDesc.classList.contains('show')) {
                afterSelected();
            };
            flag = true;
            return;
        }
    }
    if(!flag) {
        noItemIsSelected();
    }
}

function afterSelected() {
    selectDesc.classList.remove('show');
    moveBtn.classList.add('show');
    archiveBtn.classList.add('show');
}

function noItemIsSelected() {
    selectDesc.classList.add('show');
    moveBtn.classList.remove('show');
    archiveBtn.classList.remove('show');
}

function normalMode() {
    console.log('normal mode');
    selectBtn.classList.add('show');
    selectDesc.classList.remove('show');
    cancelBtn.classList.remove('show');
    moveBtn.classList.remove('show');
    archiveBtn.classList.remove('show');
    document.querySelectorAll('form#items-form input[name="items[]"]').forEach(elem=> {
        elem.checked = false;
        elem.setAttribute('disabled','');
        elem.removeEventListener("change", isAnyCheckboxChecked, false)
    });
}

</script>
