<?php
/**
 *    Saint Nestor
 *    
 *    Copyright (C) 2020  Dmitry Shumilin (dr.noisier@yandex.ru)
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
namespace SaintNestor;

interface StringHandlerInterface
{
    /**
     * This method will help you, if you need to check a presence of some symbols in a string.
     * 
     * @param string $string
     * @param array $symbols
     * @param bool $acceptable_to_find
     * @return bool
     */
    public static function checkStringSymbols(string $string, array $symbols, bool $acceptable_to_find = true);

    /**
     * Method for interpolate context to message.
     * 
     * @param string $message
     * @param array $context
     * @return string
     */
    public static function interpolateContextToMessage(string $message, array $context);

}
