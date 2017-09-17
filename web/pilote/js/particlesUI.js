$(function() {
    
    /**
    * Scan parameters
    */
    
    var mapBundlesArray;
    
    function showOrHideVendorBundles (event) {
        $('.scanBundlesParameters > span').removeClass('onAir');
        if($(this).parent('span').hasClass('useVendor')) {
            $('div.thisScanResult ul.bundleList').removeClass('hideVendorBundles');
            $(this).parent('span.useVendor').addClass('onAir');
            $('.isVendorContainer > input').prop('checked', true);
            $('.bundleList .bundles.vendorBundle').each(function() {
                if($('.bundleControls > .bundleControl > input', this).is(':checked')){
                    var targettedBundleName = $('.bundleName', this).text()
                    $('.mapSetupForm .mappedBundleContainer select option[value="'+targettedBundleName+'"]').prop('selected', true); 
                }
            });
        }
        else {
            $('div.thisScanResult ul.bundleList').addClass('hideVendorBundles');
            $(this).parent('span.dismissVendor').addClass('onAir');
            $('.isVendorContainer > input').prop('checked', false);
            $('.mapSetupForm .mappedBundleContainer select option[data-vendor=true]').prop('selected', false);
        }
    }
    
    function materializeUnscannedBundle (event) {
        if($(this).children('input').is(':checked')) {
            $(this).parent('div.bundleControls').parent('li.bundles').removeClass('doNotScanThisBundle');
        }
        else {
            $(this).parent('div.bundleControls').parent('li.bundles').addClass('doNotScanThisBundle');
        }
    }
    
    function bundlesListActions () {
        $('div.scanBundlesParameters span input').on('click.showOrHideVendorBundles', showOrHideVendorBundles);
        $('span.scanThisBundle').on('click.materializeUnscannedBundle', materializeUnscannedBundle);
    }
    
    function constructMapForm () {
        setIfVendorsAreUsed();
        createMapBundlesArray();
    }
    
    function setIfVendorsAreUsed () {
        if($('div.thisScanResult ul.bundleList').hasClass('hideVendor')) {
            $('input#form_useVendor').prop('checked', false);
        }
        else {
            $('input#form_useVendor').prop('checked', true);
        }
    }
    
    function createMapBundlesArray () {
        var thisMapBundlesArray = [];
        
        $('div.thisScanResult ul.bundleList li.bundles').each(function() {
            var thisBundleProperty = {};
            var classesOfThisBundle = $(this).attr('class');
            var nameOfThisBundle = classesOfThisBundle.replace('bundles', '');
            
            if($(this).hasClass('doNotScanThisBundle')) {
                nameOfThisBundle = nameOfThisBundle.replace('doNotScanThisBundle', '');
            }
            
            if($(this).hasClass('vendorBundle')) {
                nameOfThisBundle = nameOfThisBundle.replace('vendorBundle', '');
                thisBundleProperty.type = 'vendor';
            }
            else {
                thisBundleProperty.type = 'craft';
            }
            
            thisBundleProperty.name = nameOfThisBundle;
            if($('div.bundleControls span.scanThisBundle input', this).is(':checked')) {
                thisBundleProperty.isUsed = true;
            }
            else {
                thisBundleProperty.isUsed = false;
            }
            
            thisMapBundlesArray.push(thisBundleProperty);
        });
        
        mapBundlesArray = thisMapBundlesArray;
        console.log(mapBundlesArray);
    }
    
    function relyBundleSelectionToForm (event) {
        var nameOfThisBundle = $(this).attr('data-bundleName');
        
        if($(this).is(':checked')) {
            $('.mapSetupForm .mappedBundleContainer select option[value="'+nameOfThisBundle+'"]').prop('selected', true);
        }
        else {
            $('.mapSetupForm .mappedBundleContainer select option[value="'+nameOfThisBundle+'"]').prop('selected', false);
        }
    }
    
    if($('section.scanResultPage div.thisScanResult').length ) {
        bundlesListActions();
        //constructMapForm();
        //createMapBundlesArray();
        $('div.bundleControls span.scanThisBundle input').on('click.relyBundleSelectionToForm', relyBundleSelectionToForm);
    }
    
    /**
    * Construct map
    */
    var mapContainer;
    var mapLoopHoleOffset;
    var mapContainerOffset = {left: 0, top: 0};
    var previousMouseX;
    var previousMouseY;
    
    /* --- Map Set --- */
    function setMapContainerSize (width, height) {
        mapContainer.css('width', width+'px');
        mapContainer.css('height', height+'px');
    }
    
    function positionBundles() {
        $('.bundleContainer', mapContainer).each( function(){
            $(this).css('left', $(this).attr('data-left')+'px');
            $(this).css('top', $(this).attr('data-top')+'px');
        });
    }
    
    function positionEntities() {
        $('.bundleContainer .entities .entity', mapContainer).each( function(){
            $(this).css('left', $(this).attr('data-left')+'px');
            $(this).css('top', $(this).attr('data-top')+'px');
        });
    }
    
    function relyEntities (){
        $('.entities .entity').each(function(entityIndex, entityValue){
            var relatedBundleId = $(this).parents('.bundleContainer').attr('id');
            
            var mapContainerOffset = $('.mapContainer').offset();
            var bundleOffset = $(this).parents('.bundleContainer').offset();
            var bundleHeight = $(this).parents('.bundleContainer').outerHeight();
            var bundleHeight = $(this).parents('.bundleContainer').outerHeight();
            var bundleConnectorOffset = bundleHeight / 2;
            var bundleConnectorTop = bundleConnectorOffset - 6;
            var bundleConnectorLeft = -14;
            var entityOffset = $(this).offset();
            var entityHeight = $(this).outerHeight();
            var entityConnectorOffset = entityHeight / 2;
            var entityConnectorTop = entityConnectorOffset - 6;
            var entityConnectorLeft = -14;
            var bundleLeft = bundleOffset.left - mapContainerOffset.left;
            var bundleTop = bundleOffset.top - mapContainerOffset.top + bundleConnectorOffset;
            var entityLeft = entityOffset.left - mapContainerOffset.left - bundleLeft;
            var entityTop = entityOffset.top - mapContainerOffset.top  - bundleTop + entityConnectorOffset;
            var startPointX = entityLeft / 8;
            if(startPointX < 20){
               startPointX = 20;
            }
            var endPointX = entityLeft - (entityLeft / 10);
            var startPointY = entityTop + (entityTop / 10);
            var endPointY = entityTop + (entityTop / 6);
            var ratioXonY = entityLeft / entityTop;
            if(ratioXonY > 1){
                var halfOfTheXonYRatio = ratioXonY / 2;
                console.log('halfOfTheXonYRatio :: '+halfOfTheXonYRatio);
                if(halfOfTheXonYRatio > 1){
                    startPointY = entityTop * halfOfTheXonYRatio;
                    endPointY = (entityTop * halfOfTheXonYRatio) * 0.66;
                }
                else {
                    startPointY = entityTop + (entityTop * halfOfTheXonYRatio);
                }
            }
            var curve = 'M'+( bundleLeft - 8 )+' '+bundleTop+' c -'+startPointX+' '+startPointY+', '+endPointX+' '+endPointY+', '+( entityLeft + 1 )+' '+entityTop+'';
            
            $('.mapContainer .wiresContainer .bundleLevelWires').append('<svg data-relatedElements="rely->Entity::'+entityIndex+'->toBundle::'+relatedBundleId+'" class="wire" height="1" width="1"><g><path d=" '+curve+'" stroke="#DF6659" stroke-width="1" fill="none" /></g></svg>');
            $(this).prepend('<div class="connector entityConnector" style="top: '+entityConnectorTop+'px; left: '+entityConnectorLeft+'px;"></div>');
            if(! $(this).parents('.bundleContainer').hasClass('isLinked')){
                $(this).parents('.bundleContainer').prepend('<div class="connector bundleConnector" style="top: '+bundleConnectorTop+'px; left: '+bundleConnectorLeft+'px;"></div>');
                $(this).parents('.bundleContainer').addClass('isLinked')
            }
            
        });
    }
    
    function positionComponant() {
        $('.bundleContainer .entities .entity .entityComponants .componant', mapContainer).each( function(){
            $(this).css('left', $(this).attr('data-left')+'px');
            $(this).css('top', $(this).attr('data-top')+'px');
        });
    }
    
    /* --- Map Navigation --- */
    function moveAround (event) {
        var mouseX = event.pageX - mapLoopHoleOffset.left;
        var mouseY = event.pageY - mapLoopHoleOffset.top;
        
        var newLeft = mouseX - previousMouseX + mapContainerOffset.left;
        var newTop = mouseY - previousMouseY + mapContainerOffset.top;
        mapContainer.css('left', newLeft);
        mapContainer.css('top', newTop);
    }
    
    function listenIfMoving (event) {
        if(mapContainer.has(event.target).length > 0){
            return;
        }
        event.stopImmediatePropagation();
        
        mapContainer.css( 'cursor', 'move' );
        
        mapContainerOffset.left = parseInt(mapContainer.css('left').replace('px', ''));
        mapContainerOffset.top = parseInt(mapContainer.css('top').replace('px', ''));
        mapLoopHoleOffset = mapContainer.parent('.loopHole').offset();
        previousMouseX = event.pageX - mapLoopHoleOffset.left;
        previousMouseY = event.pageY - mapLoopHoleOffset.top;
        
        mapContainer.on('mousemove.moveAround', moveAround);
        mapContainer.on('mouseup.stopMovingAround', stopMovingAround);
        
    }
    
    function stopMovingAround (event) {
        mapContainer.css( 'cursor', 'default' );
        mapContainer.off('.listenIfMoving');
        mapContainer.off('.moveAround');
        startMapNagivation();
    }
    
    function startMapNagivation () {
        mapContainer.off('.stopMovingAround');
        mapContainer.on('mousedown.listenIfMoving', listenIfMoving);
    }
    
    function buildMap () {
        mapContainer = $('.mapContainer');
        setMapContainerSize(mapContainer.attr('data-width'), mapContainer.attr('data-height'));
        positionBundles();
        positionEntities();
        relyEntities();
        positionComponant();
        startMapNagivation();
    }
    
    if($('.loopHole .mapContainer').length) {
        buildMap();
    }
});