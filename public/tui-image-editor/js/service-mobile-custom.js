/**
 * service-mobile.js
 * @author NHN. FE Development Team <dl_javascript@nhn.com>
 * @fileoverview
 */
/* eslint-disable vars-on-top,no-var,strict,prefer-template,prefer-arrow-callback,prefer-destructuring,object-shorthand,require-jsdoc,complexity */
'use strict';

var MAX_RESOLUTION = 3264 * 2448; // 8MP (Mega Pixel)

var supportingFileAPI = !!(window.File && window.FileList && window.FileReader);
var rImageType = /data:(image\/.+);base64,/;
var shapeOpt = {
    fill: '#fff',
    stroke: '#000',
    strokeWidth: 10,
};
var activeObjectId;

// Selector of image editor controls
var submenuClass = '.submenu';
var hiddenmenuClass = '.hiddenmenu';

var $controls = $('.tui-image-editor-controls');
var $menuButtons = $controls.find('.menu-button');
var $submenuButtons = $controls.find('.submenu-button');
var $btnShowMenu = $controls.find('.btn-prev');
var $msg = $controls.find('.msg');

var $subMenus = $controls.find(submenuClass);
var $hiddenMenus = $controls.find(hiddenmenuClass);

// Image editor controls - top menu buttons
var $btnUndo = $('#btn-undo');
var $btnRedo = $('#btn-redo');
var $btnRemoveActiveObject = $('#btn-remove-active-object');

// Image editor controls - bottom menu buttons
var $btnCrop = $('#btn-crop');
var $btnAddText = $('#btn-add-text');

// Image editor controls - bottom submenu buttons
var $btnApplyCrop = $('#btn-apply-crop');
var $btnRotateClockwise = $('#btn-rotate-clockwise');
var $btnRotateCounterClockWise = $('#btn-rotate-counter-clockwise');

// Create image editor
var imageEditor = new tui.ImageEditor('.tui-image-editor', {
    cssMaxWidth: document.documentElement.clientWidth,
    cssMaxHeight: document.documentElement.clientHeight,
    applyCropSelectionStyle: true,
    selectionStyle: {
        rotatingPointOffset: 100,
        cornerStyle: 'circle',
        cornerSize: 200,
        cornerColor: '#fff',
        cornerStrokeColor: '#fff',
        transparentCorners: false,
        lineWidth: 8,
        borderColor: '#fff'
    },
});

var $displayingSubMenu, $displayingHiddenMenu;

function showSubMenu(type) {
    var index;

    switch (type) {
        case 'shape':
            index = 3;
            break;
        case 'icon':
            index = 4;
            break;
        case 'text':
            index = 5;
            break;
        default:
            index = 0;
    }

    $displayingSubMenu.hide();
    $displayingHiddenMenu.hide();

    $displayingSubMenu = $menuButtons.eq(index).parent().find(submenuClass).show();
}

// Bind custom event of image editor
imageEditor.on({
    undoStackChanged: function (length) {
        if (length) {
            $btnUndo.removeClass('disabled');
        } else {
            $btnUndo.addClass('disabled');
        }
    },
    redoStackChanged: function (length) {
        if (length) {
            $btnRedo.removeClass('disabled');
        } else {
            $btnRedo.addClass('disabled');
        }
    },
});

// Image editor controls action
$menuButtons.on('click', function () {
    $displayingSubMenu = $(this).parent().find(submenuClass).show();
    $displayingHiddenMenu = $(this).parent().find(hiddenmenuClass);
});

$submenuButtons.on('click', function () {
    $displayingHiddenMenu.hide();
    $displayingHiddenMenu = $(this).parent().find(hiddenmenuClass).show();
});

$btnShowMenu.on('click', function () {
    $displayingSubMenu.hide();
    $displayingHiddenMenu.hide();
    $msg.show();

    imageEditor.stopDrawingMode();
});

// Undo action
$btnUndo.on('click', function () {
    if (!$(this).hasClass('disabled')) {
        imageEditor.undo();
    }
});

// Redo action
$btnRedo.on('click', function () {
    if (!$(this).hasClass('disabled')) {
        imageEditor.redo();
    }
});

// Remove active object action
$btnRemoveActiveObject.on('click', function () {
    imageEditor.removeObject(activeObjectId);
});

// Crop menu action
$btnCrop.on('click', function () {
    console.log('hi');
    imageEditor.startDrawingMode('CROPPER');
    imageEditor.setCropzoneRect(1 / 1);
});

$btnApplyCrop.on('click', function () {
    imageEditor.crop(imageEditor.getCropzoneRect()).then(function () {
        imageEditor.stopDrawingMode();
        $subMenus.removeClass('show');
        $hiddenMenus.removeClass('show');
    });
});

// Orientation menu action
$btnRotateClockwise.on('click', function () {
    imageEditor.rotate(90);
});

$btnRotateCounterClockWise.on('click', function () {
    imageEditor.rotate(-90);
});

imageEditor.loadImageFromURL('https://days-photo.s3.ap-northeast-1.amazonaws.com/0307359d-cb09-430a-be0f-92d768b3f0d2.jpg', 'SampleImage').then(function () {
    imageEditor.clearUndoStack();
});
