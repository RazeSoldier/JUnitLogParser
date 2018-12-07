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

use RazeSoldier\JUnitLogParser\Component\{
    IMainComponent,
    IFaultComponent
};

/**
 * Used to find faults in a main component
 * @package RazeSoldier\JUnitLogParser
 */
class FaultSearcher
{
    /**
     * @var IMainComponent
     */
    private $component;

    public function __construct(IMainComponent $component)
    {
        $this->component = $component;
    }

    /**
     * @return string[]|false
     */
    public function search()
    {
        if (!$this->component->hasChildren()) {
            return false;
        }
        $faults = [];
        foreach ($this->component->getChildren() as $child) {
            if ($child instanceof IFaultComponent) {
                $faults[] = [
                    'type' => $child->getType(),
                    'text' => $child->getText()
                ];
                continue;
            }
            if (!$child instanceof IMainComponent) {
                continue;
            }
            $result = (new self($child))->search();
            if ($result !== false) {
                $faults = array_merge($faults, $result);
            }
        }
        if (count($faults) === 0) {
            return false;
        }
        return $faults;
    }
}
