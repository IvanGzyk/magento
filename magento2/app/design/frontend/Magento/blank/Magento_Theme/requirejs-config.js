/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    paths: {
            'bootstrap':'Magento_Theme/js/bootstrap.bundle',
    } ,
    shim: {
        'bootstrap': {
            'deps': ['jquery']
        }
    },
    deps: [
        'Magento_Theme/js/responsive',
        'Magento_Theme/js/theme'
    ]
};
