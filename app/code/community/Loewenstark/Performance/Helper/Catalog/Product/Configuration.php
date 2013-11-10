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
class Loewenstark_Performance_Helper_Catalog_Product_Configuration
extends FireGento_GermanSetup_Helper_Catalog_Product_Configuration
{
    /**
     * Get the product for the current quote item
     *
     * @param  Mage_Catalog_Model_Product_Configuration_Item_Interface $item
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct($item)
    {
        return $item->getProduct();
    }
}