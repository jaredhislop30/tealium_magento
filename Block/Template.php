<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 22.08.17
 * Time: 15:35
 */

namespace Tealium\Tags\Block;

class Template extends \Magento\Framework\View\Element\Template
{

    private $objectManager;

    private $tealiumType;
    private $tealiumName;

    /**
     * @var \Magento\Framework\Registry
     */

    private $registry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->objectManager = $objectManager;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getStore()
    {
        return $this->_storeManager->getStore();
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }

    public function setType($type)
    {
        $this->tealiumType = $type;
    }

    public function getTealiumType()
    {
        return $this->tealiumType;
    }

    public function setName($name)
    {
        $this->tealiumName = $name;
    }

    public function getTealiumName()
    {
        return $this->tealiumName;
    }

    public function getRegestry()
    {
        return $this->registry;
    }
}
