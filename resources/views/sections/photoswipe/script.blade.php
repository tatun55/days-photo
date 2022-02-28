<script src="{{ asset('photoswipe/photoswipe.min.js') }}"></script>
<script src="{{ asset('photoswipe/photoswipe-ui-default.min.js') }}"></script>
<script type="module">
    var pswpElement = document.querySelectorAll('.pswp')[0];
    // build items array
    var items = @json($album->images()->pluck('id'));
    // var items = JSON.parse(itemsJson);
    console.log(items);
    var images = [];
    items.forEach(item => {
        console.log(`https://days-photo.s3.ap-northeast-1.amazonaws.com/${item}.jpg`);
        images.push({src : `https://days-photo.s3.ap-northeast-1.amazonaws.com/${item}.jpg`});
    });

    console.log(images);

    // define options (if needed)
    var options = {
        // optionName: 'option value'
        // for example:
        index: 0 // start at first slide
    };
    // Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
</script>
