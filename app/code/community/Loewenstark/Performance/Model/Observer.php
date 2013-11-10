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
    const CACHETAG = 'sales_quote_config_get_product_attributes';
    
    public function addProductQuoteConfigAttributes($observer)
    {
        if(Mage::app()->useCache('eav') && Mage::app()->loadCache(self::CACHETAG))
        {
            foreach(explode(',', Mage::app()->loadCache(self::CACHETAG)) as $_cacheRow)
            {
                $observer->getAttributes()->setData($_cacheRow, '');
            }
        } else {
            $attributes = $observer->getAttributes()->getData();
            $collection = Mage::getResourceModel('catalog/product_attribute_collection')
                    ->setItemObjectClass('catalog/resource_eav_attribute')
                    ->addFieldToFilter('additional_table.is_visible_on_checkout', array('gt' => 0))
                    ->addFieldToFilter('attribute_code', array('nin' => $attributes));
            $attrList = array();
            foreach($collection as $_attribute) {
                $attrList[] = $_attribute->getAttributeCode();
                $observer->getAttributes()->setData($_attribute->getAttributeCode(), '');
            }
            Mage::app()->saveCache(implode(',', $attrList), self::CACHETAG, array('eav'), false);
        }
    }
}