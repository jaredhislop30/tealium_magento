<?php

namespace Tealium\Tags\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Tealium\Tags\Helper\Product;

class JsAddToWish implements SectionSourceInterface
{

    protected $_customerSession;

    protected $_productHelper;

    public function __construct(
        CustomerSession $customerSession,
        Product $productHelper
    ) {
        $this->_customerSession = $customerSession;
        $this->_productHelper = $productHelper;
    }


    public function getSectionData()
    {
        
        $product_id=$this->_customerSession->getTealiumAddToWishId();
        $this->_customerSession->unsTealiumAddToWishId();

        $qty = $this->_customerSession->getTealiumAddToWishQty();
        $this->_customerSession->unsTealiumAddToWishQty();

        $result  = [];
        if ($product_id) {
            $result = ['data'=>$this->_productHelper->getProductData($product_id)];
            $result['data']['product_quantity'] = [(string)$qty];
            $result['data']['product_id'] = [(string)$product_id];
            $result['data']['tealium_event'] = 'add_to_wishlist';
        }
        
        return $result;
    }
}


