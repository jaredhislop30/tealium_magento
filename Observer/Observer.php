<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 18.08.17
 * Time: 16:50
 * checkout_cart_add_product_complete
 * checkout_cart_product_add_after
 *
 */
namespace Tealium\Tags\Observer;
use Magento\Framework\Event\ObserverInterface;
class Observer implements ObserverInterface
{

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->_objectManager = $objectManager;
        $this->_request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // $product = Mage::getModel('catalog/product')
        //                 ->load(Mage::app()->getRequest()->getParam('product', 0));
 
        // if (!$product->getId()) {
        //     return;
        // }
 
        // $categories = $product->getCategoryIds();
 
        // Mage::getModel('core/session')->setProductToShoppingCart(
        //     new Varien_Object(array(
        //         'id' => $product->getId(),
        //         'qty' => Mage::app()->getRequest()->getParam('qty', 1),
        //         'name' => $product->getName(),
        //         'price' => $product->getPrice(),
        //         'category_name' => Mage::getModel('catalog/category')->load($categories[0])->getName(),
        //     ))
        // );
    }

}