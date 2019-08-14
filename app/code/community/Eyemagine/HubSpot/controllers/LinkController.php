<?php
/**
 * EYEMAGINE - The leading Magento Solution Partner
 *
 * HubSpot Integration with Magento
 *
 * @author    EYEMAGINE <magento@eyemaginetech.com>
 * @category  Eyemagine
 * @package   Eyemagine_HubSpot
 * @copyright Copyright (c) 2016 EYEMAGINE Technology, LLC (http://www.eyemaginetech.com)
 * @license   http://www.eyemaginetech.com/license
 */

/**
 * HubSpot Integration Access Controller
 */
class Eyemagine_HubSpot_LinkController extends Mage_Core_Controller_Front_Action
{
    /**
     * Redirect the customer to the product or search page based on the product
     * name if the product is not available.
     */
    public function productAction()
    {
        $searchQuery    = $this->getRequest()->getParam('q');
        $product        = $this->_initProduct();
        $url            = null;
        $permanent      = false;
        
        // use the loaded product if it exists
        if ($product) {

            $helper  = Mage::helper('catalog/product');

            // if the product is visible, use it's URL, otherwise load the parent's URL
            if ($helper->canShow($product)) {

                $url = $helper->getProductUrl($product);
                $permanent = true;

            } elseif ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {

                // find the simple product's first parent in grouped product types
                $parentIds = Mage::getModel('catalog/product_type_grouped')
                        ->getParentIdsByChild($product->getId());

                // if no grouped parents were found, find configurable parent IDs
                if (!$parentIds) {
                    $parentIds = Mage::getModel('catalog/product_type_configurable')
                        ->getParentIdsByChild($product->getId());
                }

                // if a parent ID is found, load it and use its URL
                if (isset($parentIds[0])) {
                	
                    $this->getRequest()->setParam('id', $parentIds[0]);
                    $parent = $this->_initProduct();
                    $url = $helper->getProductUrl($parent);
                }
            }
        }
        
        // fallback to search query if product and product url is not available
        if (empty($url)) {
            if (strlen($searchQuery)) {
                // use the provided search query string (based on product name)
                $url = Mage::helper('catalogsearch')->getResultUrl($searchQuery);
            } elseif ($product && strlen($product->getName())) {
                // product exists but is disabled or invisible
                $url = Mage::helper('catalogsearch')->getResultUrl($product->getName());
            } else {
                // final fallback to home page
                $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
            }
            
            // adds message that the product is unavailable
            $session = Mage::getSingleton('core/session');
            $session->addNotice(Mage::getStoreConfig('eyehubspot/settings/unavailable_msg'));
        }
        
        // finally send the url redirect
        Mage::app()->getResponse()
            ->setRedirect($url, ($permanent) ? 301 : 302)
            ->sendResponse();
    }

    /**
     * Resamples the product image and returns the contents as raw data
     */
    public function imageAction()
    {
        try {
            // set up min max of values for the resize (smallest 50, largest 640)
            $size = (int) ($this->getRequest()->getParam('size'));
            $size = ($size > 0) ? min(max(50, $size), 640) : 100;
            
            // render the thumbnail and get the server path
            $product = $this->_initProduct(false);
            $helper = Mage::helper('catalog/image');
            $url = $helper->init($product, 'thumbnail')->resize($size ? min(max(50, $size), 640) : 100);
            $serverPath = str_replace(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB), '', (string) $url);
            $pathinfo = pathinfo($url);
            $file = @realpath($serverPath);
            // add the mime-type header
            switch ($pathinfo['extension']) {
                case 'jpg':
                    $content_type = 'image/jpeg';
                    break;
                case 'png':
                    $content_type = 'image/png';
                    break;
                case 'gif':
                    $content_type = 'image/gif';
                    break;
                case 'xbm':
                    $content_type = 'image/x-xbitmap';
                    break;
                case 'wbpm':
                    $content_type = 'image/vnd.wap.wbmp';
                    break;
                default:
                    $content_type = 'image/jpeg';
                    break;
            }
            
            // add the size header, and output
            if ($file && file_exists($file)) {
                header('Content-Type: ' . $content_type);
                header('Content-Length: ' . filesize($file));
                if (ob_get_level())
                    ob_end_clean();
                flush();
                readfile($file);
            } else {
                if ($url && $content_type) {
                    
                    $this->getResponse()
                        ->setHeader('Content-Type', $content_type)
                        ->setBody(file_get_contents((string) $url));
                }
            }
        } catch (Exception $e) {
            
            if ($url && $content_type) {
                
                $this->getResponse()
                    ->setHeader('Content-Type', $content_type)
                    ->setBody(file_get_contents((string) $url));
            }
        }
    }
    
    
    /**
     * Loads and returns the product if it exists or null
     * 
     * The addition of the $nullIfNoLoad allows the returning of an empty
     * product for the image action so that it can load the placeholder image.
     * 
     * Allows loading the product by ID or SKU.
     * 
     * @param  boolean $nullIfNoLoad
     * @return Mage_Catalog_Model_Product|null
     */
    protected function _initProduct($nullIfNoLoad = true)
    {
        $productId  = (int)$this->getRequest()->getParam('id');
        $productSku = $this->getRequest()->getParam('sku');
        $product    = null;
        
        if ($productId) {
            $product = Mage::getModel('catalog/product')->load($productId);
        } elseif (strlen($productSku)) {
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $productSku); 
        }
        
        if ($product && $nullIfNoLoad && !$product->getId()) {
            $product = null;
        } elseif (!$nullIfNoLoad && !$product) {
            $product = Mage::getModel('catalog/product');
        }
        if ($product){
	        // compare current store ID with website IDs that the product is assigned to
	        $storeId = $product->getStoreId();
	        $websiteIds = $product->getWebsiteIds();
	        
	        // if the product is not in the current store, change the store ID
	        if (!in_array($storeId, $websiteIds)) {
	        
	        	$product->setStoreId($websiteIds[0]);
	        }
         }
        return $product;
    }
}
