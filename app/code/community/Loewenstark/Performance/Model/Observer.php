<?php
/**
  * Loewenstark_Performance
  *
  * @category  Loewenstark
  * @package   Loewenstark_Performance
  * @author    Mathis Klooss <m.klooss@loewenstark.com>
  * @copyright 2013 Loewenstark Web-Solution GmbH (http://www.mage-profis.de/). All rights served.
  * @license   https://github.com/mklooss/Loewenstark_Performance/blob/master/README.md
  */
class Loewenstark_Performance_Model_Observer
{
    /**
     * 
     * @param object $observer
     */
    public function addProductQuoteConfigAttributes($observer)
    {
        $cachetag = 'magesetup_quote_attributes';
        if(Mage::app()->useCache('eav') && Mage::app()->loadCache($cachetag))
        {
            foreach(explode(',', Mage::app()->loadCache($cachetag)) as $_cacheRow)
            {
                $observer->getAttributes()->setData($_cacheRow, '');
            }
        } else {
            $collection = Mage::getResourceModel('catalog/product_attribute_collection')
                    ->setItemObjectClass('catalog/resource_eav_attribute')
                    ->addFieldToFilter('additional_table.is_visible_on_checkout', 1);
            $attrList = array();
            foreach($collection as $_attribute) {
                $attrList[] = $_attribute->getAttributeCode();
                $observer->getAttributes()->setData($_attribute->getAttributeCode(), '');
            }
            Mage::app()->saveCache(implode(',', $attrList), $cachetag, array('eav'), false);
        }
    }
}