<?php
namespace Inertia\Utility;

use Cake\Http\Client\Message as CakeMessage;

class Message extends CakeMessage
{
    /**
     * HTTP 404 code
     *
     * @var int
     */
    const STATUS_NOT_FOUND = 404;

    /**
     * HTTP 409 code
     *
     * @var int
     */
    const STATUS_CONFLICT = 409;

    /**
     * HTTP 422 code
     *
     * @var int
     */
    const STATUS_UNPROCESSABLE_ENTITY = 422;

    /**
     * HTTP 500 code
     *
     * @var int
     */
    const STATUS_INTERNAL_SERVER = 500;
}
