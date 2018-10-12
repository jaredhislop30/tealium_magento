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
        print("Construct Add to Cart");
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        print("Execute add to cart");
    }

}