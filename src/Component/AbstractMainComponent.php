<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @copyright
 */

namespace RazeSoldier\JUnitLogParser\Component;

abstract class AbstractMainComponent implements IMainComponent
{
    /**
     * @var string Suite name
     */
    protected $name;

    /**
     * @var int The count of assertions for this suite
     */
    protected $assertionsCount;

    /**
     * @var float The duration of running this suite
     */
    protected $time;

    /**
     * @var string|null The path to test suite
     */
    protected $file;

    /**
     * @var IComponent|null The parent for this component
     */
    protected $parent;

    /**
     * @var IComponent[]
     */
    protected $children = [];

    public function getName() : string
    {
        return $this->name;
    }

    public function getAssertionsCount()
    {
        return $this->assertionsCount;
    }

    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return string|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get the parent under the current component
     * @return IComponent|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setAssertionsCount($count)
    {
        $this->assertionsCount = $count;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function setParent(IMainComponent $component)
    {
        $this->parent = $component;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function addChildren(IComponent $component)
    {
        $this->children[] = $component;
    }

    public function hasChildren() : bool
    {
        return count($this->children) !== 0 ? true : false;
    }

    public function getChildren() : array
    {
        return $this->children;
    }
}
