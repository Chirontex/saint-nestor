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

class Logger implements LoggerInterface
{

    private $directory;
    private $filename;
    private $file_extension;
    private $separate_levels;

    public function __construct(array $dir_parts, string $filename = "", string $file_extension = ".log", bool $separate_levels = false)
    {
        
        $this->separate_levels = $separate_levels;
        
        if (substr($file_extension, 0, 1) === '.') $file_extension = substr($file_extension, 1);

        $file_ext_correct = StringHandler::checkStringSymbols($file_extension, array_merge(range('a', 'z'), range(0, 9)));

        if ($file_ext_correct) $this->file_extension = '.'.$file_extension;
        else $this->file_extension = '.log';

        $check_names_arr = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];

        if (StringHandler::checkStringSymbols($filename, $check_names_arr, false)) $this->filename = $filename;
        else $this->filename = date("Y-m-d");

        if ($dir_parts[0] === 'DIR') {
            
            $this->directory = __DIR__.'/';
            $i = 1;
        
        } else $i = 0;

        for ($i; $i < count($dir_parts); $i++) {

            if (StringHandler::checkStringSymbols($dir_parts[$i], $check_names_arr, false)) $this->directory .= $dir_parts[$i].'/';
            else break;

        }

        if (!file_exists($this->directory)) {

            if (!mkdir($this->directory)) throw new SaintNestorException('Saint Nestor: directory creation failure.', -99);

        }

    }

    public function emergency(string $message, array $context = [])
    {
        
    }

    public function alert(string $message, array $context = [])
    {
        
    }

    public function critical(string $message, array $context = [])
    {
        
    }

    public function error(string $message, array $context = [])
    {
        
    }

    public function warning(string $message, array $context = [])
    {
        
    }

    public function notice(string $message, array $context = [])
    {
        
    }

    public function info(string $message, array $context = [])
    {
        
    }

    public function debug(string $message, array $context = [])
    {
        
    }

    public function log(int $level, string $message, array $context = [])
    {
        
    }

}
