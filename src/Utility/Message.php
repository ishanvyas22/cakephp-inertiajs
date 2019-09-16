<?php
namespace InertiaCake\Utility;

use Cake\Http\Client\Message as CakeMessage;

class Message extends CakeMessage
{
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
}
