/**
 * EYEMAGINE - The leading Magento Solution Partner
 *
 * HubSpot Integration with Magento
 *
 * @author    EYEMAGINE <magento@eyemaginetech.com>
 * @category  Eyemagine
 * @package   Eyemagine_HubSpot
 * @copyright Copyright (c) 2013 EYEMAGINE Technology, LLC (http://www.eyemaginetech.com)
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
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

  - Magento Enterprise Edition 1.10.1.0 to 1.12.0.2
  - Magento Community Edition 1.4.2.0 to 1.7.0.2


-------------------------------------------------------------------------------
RELEASE NOTES:
-------------------------------------------------------------------------------

v.1.0.1: September 5, 2013
  - Added controllers to handle product urls and images
  - Added redirect to search results page for name when product is not
    available
  - Minor bug fixes

v.1.0.0: July 8, 2013
  - Initial release.
