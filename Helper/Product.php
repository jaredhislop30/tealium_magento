<?php

namespace Tealium\Tags\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class Product extends AbstractHelper
{

    protected $_storeManager;

    protected $_productRepository;

    protected  $_categoryCollectionFactory;

    protected $_categoryRepository;

    public function __construct(
        StoreManagerInterface $storeManager, 
        ProductRepositoryInterface $productRepository,
        CollectionFactory $categoryCollectionFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->_storeManager = $storeManager;
        $this->_productRepository = $productRepository;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryRepository = $categoryRepository;
    }

    public function getProductData($product_id) {
        $result = [];
        $product = $this->_productRepository->getById($product_id);
        $result['product_name'] = $product->getName();
        $result['product_price'] = $product->getPrice();
        $result['product_sku'] = $product->getSku();
        $result['product_list_price']  = $product->getSpecialPrice();
        $result['product_category'] = '';
        $result['product_subcategory'] = '';
        
        $result['product_discount'] = 0;
        if ($result['product_price'] && $result['product_list_price'] && $result['product_price'] != $result['product_list_price']) {
            $result['product_discount'] = 100 - round(($result['product_list_price'] / $result['product_price'])*100);
        }

        $categoryIds = $product->getCategoryIds(); 
        
        $mainCategory = false;
        $subCategory = false;

        // get main and subcategory from all category of the product
        foreach ($categoryIds as $id) {
            $category = $this->_categoryRepository->get($id, $this->_storeManager->getStore()->getId());
            if(!$mainCategory) {
                $mainCategory =  $category;
            } else {
                if ($mainCategory->getName() == $category->getParentCategory()->getName()) {
                    $subCategory = $category;
                    break;
                } else if ($category->getName() == $mainCategory->getParentCategory()->getName()) {
                    $subCategory = $mainCategory;
                    $mainCategory = $category;
                    break;
                } else {
                    $mainCategory = $category;
                }
            }
        }
        if ($mainCategory) {
            $result['product_category'] = $mainCategory->getName();
        }

        if ($subCategory) {
            $result['product_subcategory'] = $subCategory->getName();
        }

        return $result;
    }

}