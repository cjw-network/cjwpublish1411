<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\User\UserCreateStruct class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\API\Repository\Values\User;

use eZ\Publish\API\Repository\Values\Content\ContentCreateStruct;

/**
 * This class is used to create a new user in the repository
 */
abstract class UserCreateStruct extends ContentCreateStruct
{
    /**
     * User login
     *
     * @required
     *
     * @var string
     */
    public $login;

    /**
     * User E-Mail address
     *
     * @required
     *
     * @var string
     */
    public $email;

    /**
     * The plain password
     *
     * @required
     *
     * @var string
     */
    public $password;

    /**
     * Indicates if the user is enabled after creation
     *
     * @var boolean
     */
    public $enabled = true;
}
