<?php
/**
 * File CatProvider.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue62\Provider;

use PHPWeekly\Issue62\ApiAdapter\CatApiAdapter;
use PHPWeekly\Issue62\Container\StaticServiceContainer;
use PHPWeekly\Issue62\Entity\Cat;
use PHPWeekly\Issue62\Event\CatSavedEvent;
use PHPWeekly\Issue62\Event\CatSaveFailedEvent;
use PHPWeekly\Issue62\Exception\CatNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class CatProvider
 *
 * @package PHPWeekly\Issue62\Provider
 */
class CatProvider
{
    /**
     * @var CatApiAdapter
     */
    private $apiAdapter;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * CatProvider constructor
     *
     * @param CatApiAdapter $apiAdapter
     */
    public function __construct(CatApiAdapter $apiAdapter)
    {
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * Return cat from the API or create a new one
     * if the cat could not be found
     *
     * @param string $name
     * @return Cat
     */
    public function getCat($name)
    {
        try {
            return $this->apiAdapter->getCatByName($name);
        } catch (CatNotFoundException $e) {
            $cat = new Cat();
            $cat->setName($name);

            return $this->saveCat($cat);
        }
    }

    /**
     * Save/Update cat on the API
     *
     * @param Cat $cat
     * @return Cat
     * @throws \Exception
     */
    public function saveCat(Cat $cat)
    {
        $eventDispatcher = $this->getEventDispatcher();

        try {
            $this->apiAdapter->saveCat($cat);
            $eventDispatcher->dispatch(CatSavedEvent::NAME, new CatSavedEvent($cat));

            return $cat;
        } catch (\Exception $e) {
            $eventDispatcher->dispatch(CatSaveFailedEvent::NAME, new CatSaveFailedEvent($cat));

            throw $e;
        }
    }

    /**
     * Map callback function to all cats in the API
     *
     * (not to be confused with catNap which is entirely different)
     *
     * @param callable $fn
     * @return array
     */
    public function catMap(callable $fn)
    {
        $cats = $this->apiAdapter->getAllCats();

        return array_map($fn, $cats);
    }

    /**
     * Return event dispatcher service
     *
     * @return EventDispatcher
     */
    private function getEventDispatcher()
    {
        if (!$this->eventDispatcher) {
            $this->eventDispatcher = StaticServiceContainer::get('event_dispatcher');
        }

        return $this->eventDispatcher;
    }
}
