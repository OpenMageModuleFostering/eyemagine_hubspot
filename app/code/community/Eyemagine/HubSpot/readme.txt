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

-------------------------------------------------------------------------------
DESCRIPTION:
-------------------------------------------------------------------------------

Integration with Magento and HubSpot which syncs Magento customers with HubSpot
Contacts along with customer attributes, order history, abandoned carts, recent
history, and lifetime statistics.

When the HubSpot UTK javascript is included in the site, this integration will
also include timeline and user activity analytics.

To enable HubSpot Syncing you must activate the extension in the Magento Admin:

    System > Configuration > Services > HubSpot Integration > Settings
    

Module Files:

  - app/code/community/Eyemagine/HubSpot/
  - app/etc/modules/Eyemagine_HubSpot.xml


-------------------------------------------------------------------------------
COMPATIBILITY:
-------------------------------------------------------------------------------

  - Magento Enterprise Edition 1.10.1.0 to 1.14
  - Magento Community Edition 1.4.2.0 to 1.9


-------------------------------------------------------------------------------
RELEASE NOTES:
-------------------------------------------------------------------------------
v.1.1.5: Sep 8, 2016
- Fixed product and media url for multistores.
- Optimized performance for order data. 

v.1.1.4: July 5, 2016:
- Added workaround for syncing data without timestamp. 

v.1.1.3: June 14, 2016:
- Fixed performance issue for abandoned cart data.
- Fixed notification message for unavailable products.
- Added multi-store support. 

v.1.1.2: Dec 04, 2015:
- Fixed wishlist syncing.
- Fixed newsletter syncing.

v.1.1.1: Oct 05, 2015:
- Fixed 404 error message. 

v.1.1.0: Sep 11, 2015:
- Added sync for newsletter subscribers.
- Fixed sync for the address data.

v.1.0.5: Aug 31, 2015:
- Fixed product image display related issue 

v.1.0.3: July 7, 2014
- Fixed package definition 

v.1.0.2: July 7, 2014
  - Added redirects for invisible simple products
  - Added redirects for products in different stores/websites

  
v.1.0.1: September 5, 2015
  - Added controllers to handle product urls and images
  - Added redirect to search results page for name when product is not available
  - Minor bug fixes
  
v.1.0.0: July 8, 2015
  - Initial release.
