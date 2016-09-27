<?php
/**
 * File CatSaveFailedEvent.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue62\Event;

use PHPWeekly\Issue62\Entity\Cat;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CatSaveFailedEvent
 *
 * @package PHPWeekly\Issue62\Event
 */
class CatSaveFailedEvent extends Event
{
    const NAME = 'cat_save_failed';

    /**
     * @var Cat
     */
    private $cat;

    /**
     * CatSavedEvent constructor
     * @param Cat $cat
     */
    public function __construct(Cat $cat)
    {
        $this->cat = $cat;
    }

    /**
     * @return Cat
     */
    public function getCat()
    {
        return $this->cat;
    }
}
