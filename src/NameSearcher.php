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

namespace RazeSoldier\JUnitLogParser;

use RazeSoldier\JUnitLogParser\Component\IMainComponent;

/**
 * Used to search a collection via name
 * @package RazeSoldier\JUnitLogParser
 */
class NameSearcher
{
    /**
     * @var IMainComponent
     */
    private $component;

    /**
     * @var string
     */
    private $needle;

    /**
     * @var callable|null A callback that run at searching
     */
    private $hook;

    /**
     * NameSearcher constructor.
     * @param IMainComponent $component
     * @param string $needle
     * @param callable|null $hook
     */
    public function __construct(IMainComponent $component, string $needle, callable $hook = null)
    {
        $this->component = $component;
        $this->needle = $needle;
        $this->hook = $hook;
    }

    /**
     * @return IComponent|false
     */
    public function search()
    {
        if ($this->component->getName() === $this->needle) {
            return $this->component;
        }
        if (!$this->component->hasChildren()) {
            return false;
        }
        foreach ($this->component->getChildren() as $child) {
            if ($child->getName() === $this->needle) {
                if (!$this->hook($child)) {
                    continue;
                }
                return $child;
            }
            if ($child->hasChildren()) {
                foreach ($child->getChildren() as $childChild) {
                    $result = (new self($childChild, $this->needle, $this->hook))->search();
                    if ($result !== false) {
                        if (!$this->hook($result)) {
                            continue;
                        }
                        return $result;
                    }
                }
            }
        }
        return false;
    }

    private function hook(IMainComponent $result) : bool
    {
        if ($this->hook === null) {
            return true;
        }
        $pass = call_user_func($this->hook, $result);
        if ($pass === false) {
            return false;
        }
        return true;
    }
}
