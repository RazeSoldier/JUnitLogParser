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

class TestCase extends AbstractMainComponent implements ITestCase
{
    /**
     * @var string|null
     */
    private $class;

    /**
     * @var string|null
     */
    private $classname;

    /**
     * @var int|null
     */
    private $line;

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * @return int|null
     */
    public function getLine() : ?int
    {
        return $this->line;
    }

    /**
     * @param string|null $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @param string|null $classname
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;
    }

    /**
     * @param int|null $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }
}
