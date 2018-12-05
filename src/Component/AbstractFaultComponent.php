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

abstract class AbstractFaultComponent implements IFaultComponent
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $text;

    /**
     * IMainComponent The parent for this component
     */
    protected $parent;

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setParent(IMainComponent $component)
    {
        $this->parent = $component;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function getParent() : IMainComponent
    {
        return $this->parent;
    }
}
