<?php

namespace Tealium\Tags\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Tealium\Tags\Helper\Product;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;

class JsUpdateQty implements SectionSourceInterface
{

    protected $_customerSession;

    protected $_productHelper;

    protected $_checkoutSession;

    protected $_productRepository;

    public function __construct(
        CustomerSession $customerSession,
        Product $productHelper,
        ProductRepositoryInterface $productRepository,
        CheckoutSession $checkoutSession
    ) {
        $this->_customerSession = $customerSession;
        $this->_productHelper = $productHelper;
        $this->_checkoutSession = $checkoutSession;
        $this->_productRepository = $productRepository;
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
                    $product = $this->_productRepository->get($quoteItem->getSku());
                    /*$product = $this->_productRepository->getById($product->getId());
                    echo get_class($quoteItem).'    ';
                    echo $quoteItem->getSpecialPrice().'    '; 
                    echo $quoteItem->getProductId().'    '; 
                    echo get_class($quoteItem->getProductOption()).'    '; 
                    echo $product->getName().'    '; 
                    exit;*/
                    $productData = $this->_productHelper->getProductData($product->getId());
                    array_push($result['data']['product_category'], $productData['product_category'][0]);
                    array_push($result['data']['product_discount'], $productData['product_discount'][0]);
                    array_push($result['data']['product_name'], $quoteItem->getName());
                    array_push($result['data']['product_id'], $quoteItem->getProductId());
                    array_push($result['data']['product_list_price'], $productData['product_list_price'][0]);
                    array_push($result['data']['product_quantity'], $quoteItem->getQty());
                    array_push($result['data']['product_sku'], $quoteItem->getSku());
                    array_push($result['data']['product_subcategory'], $productData['product_subcategory'][0]);
                    array_push($result['data']['product_unit_price'], (string)number_format((float)$quoteItem->getPrice(), 2, '.', ''));
                }
            }
        }
        return $result;
    }
}


