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
class Loewenstark_MageSetup_Helper_Data
extends Mage_Core_Helper_Abstract
{
    protected $_mageSetup = null;

    /**
     * 
     * @return type
     */
    public function isOldMageSetup()
    {
        if(is_null($this->_mageSetup))
        {
            $this->_mageSetup = !(version_compare($this->getMageSetupVersion(), '2.1.2') >= 0);
        }
        return $this->_mageSetup;
    }
    
    /**
     * 
     * @return string
     */
    protected function getMageSetupVersion()
    {
        return (string)Mage::getConfig()->getNode('modules/FireGento_MageSetup/version');
    }
}