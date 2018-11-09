<?php

namespace Tealium\Tags\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Tealium\Tags\Helper\Product;
use Magento\Checkout\Model\Session as CheckoutSession;

class JsUpdateQty implements SectionSourceInterface
{

    protected $_customerSession;

    protected $_productHelper;

    protected $_checkoutSession;

    public function __construct(
        CustomerSession $customerSession,
        Product $productHelper,
        CheckoutSession $checkoutSession
    ) {
        $this->_customerSession = $customerSession;
        $this->_productHelper = $productHelper;
        $this->_checkoutSession = $checkoutSession;
    }
    
    public function getSectionData()
    {
        $productIdList=$this->_customerSession->getTealiumQty();
        $this->_customerSession->unsTealiumQty();
        
        $result = [];
        if ($productIdList) {


            $result = [
                'data'=>[ 
                    'product_category'=>[],
                    'product_discount'=>[],
                    'product_id'=>[],
                    'product_list_price'=>[],
                    'product_name'=>[],
                    'product_quantity'=>[],
                    'product_sku'=>[],
                    'product_subcategory'=>[],
                    'product_unit_price'=>[],
                    'tealium_event'=>'cart_update_item_quanity'
                ]
            ];

            $quoteList=$this->_checkoutSession->getQuote()->getAllVisibleItems();

            foreach ($quoteList as $quoteItem) {
                if (in_array($quoteItem->getItemId(), $productIdList)){
                    $productData = $this->_productHelper->getProductData($quoteItem->getProductId());
                    array_push($result['data']['product_category'], $productData['product_category'][0]);
                    array_push($result['data']['product_discount'], $productData['product_discount'][0]);
                    array_push($result['data']['product_name'], $productData['product_name'][0]);
                    array_push($result['data']['product_id'], $quoteItem->getProductId());
                    array_push($result['data']['product_list_price'], $productData['product_list_price'][0]);
                    array_push($result['data']['product_quantity'], $quoteItem->getQty());
                    array_push($result['data']['product_sku'], $productData['product_sku'][0]);
                    array_push($result['data']['product_subcategory'], $productData['product_subcategory'][0]);
                    array_push($result['data']['product_unit_price'], $productData['product_unit_price'][0]);
                }
            }
        }
        return $result;
    }
}


