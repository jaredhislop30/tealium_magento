<?php
class Tealium_Tags_Model_Observer {

    protected $_logger;
    public function __construct(
        \Psr\Log\LoggerInterface $logger, //log injection
        array $data = []
    ) {
        print("construct");
        $this->_logger = $logger;
        parent::__construct($data);
    }
    public function execute() {
        print("execute");
        /*
        some logic of method
        */
        //accessing to logger instance and calling log method
        $this->_logger->addDebug('Triggered Observer');
    }

}
