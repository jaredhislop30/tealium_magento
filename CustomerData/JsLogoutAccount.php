<?php

namespace Tealium\Tags\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\Session\SessionManagerInterface as CoreSession;

class JsLogoutAccount implements SectionSourceInterface
{

    protected $_coreSession;

    public function __construct(
        CoreSession $coreSession
    ) {
        $this->_coreSession = $coreSession;
    }

    public function getSectionData()
    {
        $email = $this->_coreSession->getTealiumLogoutAccEmail();
        $this->_coreSession->unsTealiumLogoutAccEmail();

        $type = $this->_coreSession->getTealiumLogoutAccType();
        $this->_coreSession->unsTealiumLogoutAccType();

        $id = $this->_coreSession->getTealiumLogoutAccId();
        $this->_coreSession->unsTealiumLogoutAccId();

        $result = [];

        if ($id) {
            $result['data']['customer_email'] = $email;
            $result['data']['customer_id'] = $id;
            $result['data']['customer_type'] = $type;
            $result['data']['tealium_event'] = 'user_logout';
        }
        
        return $result;
    }
}


