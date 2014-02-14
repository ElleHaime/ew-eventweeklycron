<?php
/**
 * @namespace
 */
namespace Cron\Models\MessageCenter\Handler;

use QueueCenter\Queue\HandlerCallbackInterface,
    Library\Traits\DIaware,
    Library\Traits\Observable,
    Library\Traits\Message;

/**
 * Class McMailNotification
 * @package Cron\Models\MessageCenter\Handler
 */
abstract class Base implements HandlerCallbackInterface
{
    use DIaware,Observable,Message;
}