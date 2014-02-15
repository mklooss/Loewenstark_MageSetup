<?php
/**
  * Loewenstark_MageSetup
  *
  * @category  Loewenstark
  * @package   Loewenstark_MageSetup
  * @author    Mathis Klooss <m.klooss@loewenstark.com>
  * @copyright 2013 Loewenstark Web-Solution GmbH (http://www.mage-profis.de/). All rights served.
  * @license   https://github.com/mklooss/Loewenstark_MageSetup/blob/master/README.md
  */
class Loewenstark_MageSetup_Helper_Catalog_Product_Configuration
extends FireGento_MageSetup_Helper_Catalog_Product_Configuration
{
    /**
     * Get the product for the current quote item
     *
     * @param  Mage_Catalog_Model_Product_Configuration_Item_Interface $item
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct($item)
    {
        if(Mage::helper('loewenstark_magesetup')->isOldMageSetup())
        {
            return $item->getProduct();
        }
        return parent::_getProduct($item);
    }
    
    /**
     * Retrieve the attributes which are visible on the checkout page
     *
     * @param  Mage_Catalog_Model_Product $product Product Model
     * @return array Addition data as array
     */
    protected function _getAdditionalData(Mage_Catalog_Model_Product $product)
    {
        if(Mage::helper('loewenstark_magesetup')->isOldMageSetup())
        {
            $data = array();

            $attributes = $product->getAttributes();
            foreach ($attributes as $attribute) {
                if ($attribute->getIsVisibleOnCheckout()) {
                    if(in_array($attribute->getFrontendInput(), array('select','multiselect')) && !$product->getData($attribute->getAttributeCode()))
                    {
                        continue;
                    }
                    $value = $attribute->getFrontend()->getValue($product);
                    if (!$product->hasData($attribute->getAttributeCode()) || (string) $value == '') {
                        $value = '';
                    } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                        $value = Mage::app()->getStore()->convertPrice($value, true);
                    }

                    if (is_string($value) && strlen($value)) {
                        $data[$attribute->getAttributeCode()] = array(
                            'label'       => $attribute->getStoreLabel(),
                            'value'       => $value,
                            'print_value' => $value,
                            'code'        => $attribute->getAttributeCode()
                        );
                    }
                }
            }

            return $data;
        }
        return parent::_getAdditionalData($product);
    }
}