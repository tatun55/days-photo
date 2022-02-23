var $btnCrop = $('.tie-btn-crop');
$btnCrop.off();
$btnCrop.on('click', function () {
    console.log('hi');
    imageEditor.startDrawingMode('CROPPER');
    imageEditor.setCropzoneRect(1 / 1);
    $displayingSubMenu.hide();
    // $displayingSubMenu = $cropSubMenu.show();
});
