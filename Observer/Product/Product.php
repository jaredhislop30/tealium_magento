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

namespace Tealium\Tags\Observer\Product;

use Magento\Framework\Event\ObserverInterface;

class Product implements ObserverInterface
{
    /**
 
     * Below is the method that will fire whenever the event runs!
 
     *
 
     * @param Observer $observer
 
     */
 
    public function execute(Observer $observer)
 
    {
 
        $product = $observer->getProduct();
 
        $originalName = $product->getName();
 
        $modifiedName = $originalName . ' - Modified by Magento 2 Events and Observers';
 
        $product->setName($modifiedName);
 
    }

}