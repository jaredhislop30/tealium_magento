<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 18.08.17
 * Time: 16:50
 */

namespace Tealium\Tags\Observer;

use Magento\Framework\Event\ObserverInterface;

class tealium_tags_model_Observer
{
    public function logCartAdd() {
 
        $product = Mage::getModel('catalog/product')
                        ->load(Mage::app()->getRequest()->getParam('product', 0));
 
        if (!$product->getId()) {
            return;
        }
 
        $categories = $product->getCategoryIds();
 
        Mage::getModel('core/session')->setProductToShoppingCart(
            new Varien_Object(array(
                'id' => $product->getId(),
                'qty' => Mage::app()->getRequest()->getParam('qty', 1),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'category_name' => Mage::getModel('catalog/category')->load($categories[0])->getName(),
            ))
        );
    }
}