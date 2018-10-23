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
class Product implements ObserverInterface
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
        $product = $observer->getProduct();
 
        $originalName = $product->getName();
 
        $modifiedName = $originalName . ' - Modified by Magento 2 Events and Observers';
 
        $product->setName($modifiedName);
    }

}