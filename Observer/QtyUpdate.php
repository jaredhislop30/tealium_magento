<?php
namespace Tealium\Tags\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Request\Http;
use Magento\Checkout\Model\Cart;

class QtyUpdate implements ObserverInterface
{

    protected $_customerSession;

    protected $_request;

    public function __construct(
        CustomerSession $customerSession,
        Cart $cart,
        Http $request
    ) {
        $this->_customerSession = $customerSession;
        $this->_request = $request;
        $this->_cart = $cart;
    }

    /**
     *
     * Add data to section array for custumer data use
     *
     */

    public function execute(Observer $observer) 
    {   
        //echo get_class($observer->getData()['event']); exit;
        $requestParamList = $this->_request->getParams();
        if (array_key_exists('item_id', $requestParamList)) {
            $this->_customerSession->setTealiumQty([$requestParamList['item_id']]);
        }
        
        return $this;
    }
}