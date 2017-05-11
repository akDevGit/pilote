$(function() {
    
    /**
    * Scan parameters
    */
    
    var mapBundlesArray;
    
    function showOrHideVendorBundles (event) {
        if($(this).parent('span').hasClass('useVendor')) {
            $('div.thisScanResult ul.bundleList').removeClass('hideVendorBundles');
        }
        else {
            $('div.thisScanResult ul.bundleList').addClass('hideVendorBundles');
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
    
    if($('section.scanResultPage div.thisScanResult').length ) {
        bundlesListActions();
        constructMapForm();
        createMapBundlesArray();
        $('div.bundleControls span.scanThisBundle input').on('click.createMapBundlesArray', createMapBundlesArray);
    }
});