<?php
class Tealium_Tags_Model_Observer {

    public function example($observer) {
        //$observer contains data passed from when the event was triggered.
        //You can use this data to manipulate the order data before it's saved.
        //Uncomment the line below to log what is contained here:
        //Mage::log($observer);

        Mage::log('We just made an Observer!');
    }

}