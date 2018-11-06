<?php
namespace Tealium\Tags\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Request\Http;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;

class AddProduct implements ObserverInterface
{

    protected $_request;

    protected $_customerSession;

    protected $_checkoutSession;

	public function __construct(
        Http $request,
        CustomerSession $customerSession,
        CheckoutSession $_checkoutSession
    ) {
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $_checkoutSession;
        $this->_request = $request;
	}

    /**
     *
     * Add data to section array for custumer data use
     *
     */

    public function execute(Observer $observer) 
    {	
        //get product from session
        $product_id=$this->_checkoutSession->getLastAddedProductId(true);

        $product_quantity = 1;
        if (isset($request['qty'])) {
        	$product_quantity = $request['qty'];
        }
        $this->_customerSession->setTealiumAddProductId($product_id);
        $this->_customerSession->setTealiumAddProductQty($product_quantity);
        
        return $this;
    }
}