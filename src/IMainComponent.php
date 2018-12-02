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

interface IMainComponent extends IComponent
{
    /**
     * @var IComponent|null Get the parent under the current component
     */
    public function getParent();

    public function addChildren(IComponent $component);

    /**
     * @return bool
     */
    public function hasChildren() : bool;

    /**
     * @return IComponent[]
     */
    public function getChildren() : array;

    public function setName(string $name);

    public function setAssertionsCount(int $count);

    public function setTime(float $time);

    public function setParent(IMainComponent $component);

    public function setFile($file);

    public function getName() : string;

    public function getAssertionsCount() : int;

    public function getTime() : float;

    public function getFile();
}
