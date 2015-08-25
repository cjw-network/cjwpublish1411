<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = $Params['Module'];

$text =
## BEGIN COPYRIGHT INFO ##
'<p>Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.</p>

<p>This file may be distributed and/or modified under the terms of the
\"GNU General Public License\" version 2 as published by the Free
Software Foundation and appearing in the file LICENSE included in
the packaging of this file.</p>

<p>Licencees holding a valid \"eZ Publish professional licence\" version 2
may use this file in accordance with the \"eZ Publish professional licence\"
version 2 Agreement provided with the Software.</p>

<p>This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.</p>

<p>The \"eZ Publish professional licence\" version 2 is available at
<a href=\"http://ez.no/ez_publish/licences/professional/\">http://ez.no/ez_publish/licences/professional/</a> and in the file
PROFESSIONAL_LICENCE included in the packaging of this file.
For pricing of this licence please contact us via e-mail to licence@ez.no.
Further contact information is available at <a href=\"http://ez.no/company/contact/\">http://ez.no/company/contact/</a>.</p>

<p>The \"GNU General Public License\" (GPL) is available at
<a href=\"http://www.gnu.org/copyleft/gpl.html\">http://www.gnu.org/copyleft/gpl.html</a>.</p>

<p>Contact eZ Systems if any conditions of this licencing isn\'t clear to you.</p>';
## END COPYRIGHT INFO ##

$Result = array();
$Result['content'] = $text;
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/ezinfo', 'Info' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/ezinfo', 'Copyright' ) ) );

?>
