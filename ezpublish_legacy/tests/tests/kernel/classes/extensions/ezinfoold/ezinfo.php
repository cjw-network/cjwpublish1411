<?php
/**
 * File containing the ezinfooldInfo class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZFindInfo ezinfo.php
  \brief The class eZFindInfo does

*/

class ezinfooldInfo
{
    static function info()
    {
        return array(
            'Name' => "Old eZ Info",
            'Version' => '1.0',
            'Copyright' => "Copyright © 2010 eZ Systems AS.",
            'Info_url' => "http://ez.no",
            'License' => "GNU General Public License v2.0",
            'Includes the following third-party software' => array(
                'name' => 'Software 1',
                'Version' => '1.1',
                'copyright' => 'Some company.',
                'license' => 'Apache License, Version 2.0',
                'info_url' => 'http://company.com',
             ),
            'Includes the following third-party software (2)' => array(
                'name' => 'Software 2',
                'Version' => '2.0',
                'copyright' => 'Some other company.',
                'license' => 'GNU Public license V2.0',
            ),
        );
    }
}

?>
