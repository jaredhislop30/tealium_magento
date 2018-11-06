<?php
namespace Tealium\Tags\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Checkout\Model\Cart;
use Tealium\Tags\Helper\Product;

class Index extends Action
{
	protected $_pageFactory;

	protected $_cart;

	protected $_productHelper;

	public function __construct(
		Context $context,
		PageFactory $pageFactory,
		Cart $cart,
		Product $productHelper
	){
		$this->_pageFactory = $pageFactory;
		$this->_cart = $cart;
		$this->_productHelper = $productHelper;
		return parent::__construct($context);
	}

	public function execute()
	{
		$cartData = $this->_cart->getQuote()->getAllVisibleItems();

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
				'product_unit_price'=>[]
			]
		];

		foreach ($cartData as $key => $value) {
			$productData = $this->_productHelper->getProductData($value->getProductId());

			array_push($result['data']['product_category'], $productData['product_category']);
			array_push($result['data']['product_discount'], $productData['product_discount']);
			array_push($result['data']['product_name'], $productData['product_name']);
			array_push($result['data']['product_id'], $value->getProductId());
			array_push($result['data']['product_list_price'], $productData['product_list_price']);
			array_push($result['data']['product_quantity'], $value->getQty());
			array_push($result['data']['product_sku'], $productData['product_sku']);
			array_push($result['data']['product_subcategory'], $productData['product_subcategory']);
			array_push($result['data']['product_unit_price'], $productData['product_list_price']);
		}
		
		echo json_encode($result);
		exit;
	}
}
