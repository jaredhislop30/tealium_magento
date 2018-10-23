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
    protected $session;
    
    public function setValue($value){
        $this->session->start();
        $this->session->setMessage($value);
     }
 
    public function getValue(){
        $this->session->start();
        return $this->session->getMessage();
    }
 
    public function unSetValue(){
        $this->session->start();
        return $this->session->unsMessage();
    }
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Session\SessionManagerInterface $session
    ) {
        $this->_objectManager = $objectManager;
        $this->_request = $request;
        $this->session = $session;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
 
        $product_name = $product->getName();

        $this->session->start();
        $this->session->setValue($product_name);
    }

}