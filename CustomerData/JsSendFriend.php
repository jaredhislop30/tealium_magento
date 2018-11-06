<?php

namespace Tealium\Tags\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Tealium\Tags\Helper\Product;

class JsSendFriend implements SectionSourceInterface
{

    protected $_customerSession;

    protected $_prosuctHelper;

    public function __construct(
        CustomerSession $customerSession,
        Product $prosuctHelper
    ) {
        $this->_customerSession = $customerSession;
        $this->_prosuctHelper = $prosuctHelper;
    }
    
    public function getSectionData()
    {
        $product_id=$this->_customerSession->getTealiumSendFriend();
        $this->_customerSession->unsTealiumSendFriend();

        $result = [];

        if ($product_id) {
            $result = ['data'=>$this->_prosuctHelper->getProductData($product_id)];
            $result['data']['product_quantity'] = 1;
            $result['data']['tealium_event'] = 'add_to_wishlist';
        }
        
        return $result;
    }
}


