<?php
/**
 * File StaticServiceContainer.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue62\Container;

use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class StaticServiceContainer
 *
 * Naive hardcoded service container since our application does not currently
 * have any support for importing any configuration information
 *
 * @package PHPWeekly\Issue62\Container
 */
final class StaticServiceContainer
{
    /**
     * Service definitions
     *
     * @var array
     */
    private static $definitions = [
        'event_dispatcher' => EventDispatcher::class,
    ];

    /**
     * Instantiated services
     *
     * @var array
     */
    private static $services = [];

    /**
     * Return service singleton
     *
     * @param $service
     * @return mixed
     * @throws \LogicException
     */
    public static function get($service)
    {
        if (!array_key_exists($service, self::$definitions[$service])) {
            throw new \LogicException(sprintf('Service %s is not defined!!!', $service));
        }

        if (!isset(self::$services[$service])) {
            self::$services[$service] = new self::$definitions[$service];
        }

        return self::$services[$service];
    }
}
