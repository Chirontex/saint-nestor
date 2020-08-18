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
abstract class SaintNestorAbstract implements SaintNestorInterface
{

    public $logs_dir;
    public $log_name_format;

    public function __construct(string $logs_dir)
    {

        $this->logs_dir = $logs_dir;

        if (!file_exists($this->logs_dir)) {
                
            if (!mkdir($this->logs_dir)) die('Failed to create directory '.$this->logs_dir.'.');
        
        }

        $this->log_name_format = '';

    }

}
