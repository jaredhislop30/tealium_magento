<?php
namespace Tealium\Tags\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Checkout\Model\Cart;
use Tealium\Tags\Helper\Product;
use \Magento\Framework\Controller\Result\JsonFactory;

class Index extends Action
{
    protected $pageFactory;

    protected $cart;

    protected $productHelper;

    private $resultJsonFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Cart $cart,
        Product $productHelper,
        JsonFactory $resultJsonFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->cart = $cart;
        $this->productHelper = $productHelper;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }


    public function execute()
    {
        //echo json_encode(phpinfo()); exit;
        $cartData = $this->cart->getQuote()->getAllVisibleItems();

        $cart_total_items = 0;
        $cart_total_value = 0;


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
                'cart_total_items'=>'',
                'cart_total_value'=>''
            ]
        ];

        foreach ($cartData as $key => $value) {
            $responseObejct = $this->resultJsonFactory->create();
            $product = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($value->getProductId());
            foreach ($value->getOptions() as $option) {
                if ($option) {
                    $optionStr = $option->getValue();
                    if ($optionStr && (strpos($optionStr, 'super_attribute') !== false)) {
                        $option_list = json_decode($optionStr);
                        $product = $this->_objectManager->get('Magento\ConfigurableProduct\Model\Product\Type\Configurable')->getProductByAttributes((array)$option_list->super_attribute, $product);
                    }
                }
            }
            $productData = $this->productHelper->getProductData($product->getId());

            $cart_total_items += $value->getQty();
            $cart_total_value += $productData['product_unit_price'][0];

            array_push($result['data']['product_category'], $productData['product_category'][0]);
            array_push($result['data']['product_discount'], $productData['product_discount'][0]);
            array_push($result['data']['product_name'], $productData['product_name'][0]);
            array_push($result['data']['product_id'], (string)$value->getProductId());
            array_push($result['data']['product_list_price'], $productData['product_list_price'][0]);
            array_push($result['data']['product_quantity'], (string)$value->getQty());
            array_push($result['data']['product_sku'], $productData['product_sku'][0]);
            array_push($result['data']['product_subcategory'], $productData['product_subcategory'][0]);
            array_push($result['data']['product_unit_price'], $productData['product_unit_price'][0]);
            for ($index = 2; $index <= 10; $index++) {
                if (isset($productData['product_subcategory_'.$index])) {
                    if (!isset($result['data']['product_subcategory_'.$index])) {
                        $result['data']['product_subcategory_'.$index] = [];
                    }
                    $count = count($result['data']['product_id'])-1;
                    while (count($result['data']['product_subcategory_'.$index]) < $count) {
                        array_push($result['data']['product_subcategory_'.$index], '');
                    }
                    array_push($result['data']['product_subcategory_'.$index], $productData['product_subcategory_'.$index][0]);
                }
            }
        }

        
        $result['data']['cart_total_items'] = strval($cart_total_items);
        $result['data']['cart_total_value'] = strval($cart_total_value);
        
        $responseObejct->setData($result);
        /*echo json_encode($result);
        exit;*/
    }
}
