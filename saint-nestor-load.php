<?php
/**
 *    Saint Nestor ver. 0.9
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
require_once __DIR__.'\\classes\\interface\\SaintNestorInterface.php';

require_once __DIR__.'\\classes\\SaintNestorAbstract.php';
require_once __DIR__.'\\classes\\SaintNestor.php';

$saint_nestor = new SaintNestor(__DIR__.'\\logs\\');
