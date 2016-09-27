<?php
/**
 * File CatApiAdapter.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue62\ApiAdapter;

use PHPWeekly\Issue62\Entity\Cat;
use PHPWeekly\Issue62\Exception\CatNotFoundException;

/**
 * Interface CatApiAdapter
 *
 * @package PHPWeekly\Issue62\ApiAdapter
 */
interface CatApiAdapter
{
    /**
     * Return array of all cats from API
     *
     * @return Cat[]
     */
    public function getAllCats();

    /**
     * Return cat from the API by name
     *
     * (Assumes that cat names are unique)
     *
     * @param string $name
     * @return Cat
     * @throws CatNotFoundException
     */
    public function getCatByName($name);

    /**
     * Save new or update an existing cat
     *
     * @param Cat $cat
     * @return null
     * @throws \Exception
     */
    public function saveCat(Cat $cat);
}
