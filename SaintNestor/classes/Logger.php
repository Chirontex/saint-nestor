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
        
        // Этим свойством будет определяться, пишем ли мы логи в разные файлы
        // в зависимости от уровня или нет. Просто запоминаем его значение.
        $this->separate_levels = $separate_levels;
        
        // Убираем точку перед проверкой. Она нам не нужна.
        if (substr($file_extension, 0, 1) === '.') $file_extension = substr($file_extension, 1);

        // Проверяем, что расширение файла состоит только из цифр и латинских букв.
        $file_ext_correct = StringHandler::checkStringSymbols($file_extension, array_merge(range('a', 'z'), range(0, 9)));

        // Если проверка прошла, то записываем пользовательское расширение и
        // возвращаем точку. Если же нет, то возвращаем дефолтное расширение.
        if ($file_ext_correct) $this->file_extension = '.'.$file_extension;
        else $this->file_extension = '.log';

        // Инициализируем массивы для проверки имени файла и частей пути директории.
        $check_dirparts_arr = ['*', '?', '"', '<', '>', '|'];
        $check_filename_arr = $check_dirparts_arr;

        $check_filename_arr[] = ':';
        $check_filename_arr[] = '/';
        $check_filename_arr[] = '\\';

        // Проверяем корректность заданного имени файла, если таковое было задано.
        // Если не было, либо было задано некорректное, то формируем дефолтное.
        if (!empty($filename) && StringHandler::checkStringSymbols($filename, $check_filename_arr, false)) $this->filename = $filename;
        else $this->filename = date("Y-m-d");

        // Если первая часть пути задана как DIR, то воспринимаем это как призыв
        // сформировать путь от __DIR__.
        if ($dir_parts[0] === 'DIR') {
            
            $this->directory = __DIR__.'/';
            $i = 1;
        
        } else $i = 0;

        // Проверяем корректность частей пути директории.
        // Если какая-то из частей оказывается некорректной, то завершаем
        // формирование пути, останавливаясь на предыдущей части как на
        // конечной директории.
        for ($i; $i < count($dir_parts); $i++) {

            if (StringHandler::checkStringSymbols($dir_parts[$i], $check_dirparts_arr, false)) {
                
                $this->directory .= $dir_parts[$i];

                if (substr($dir_parts[$i], -1) !== '/') $this->directory .= '/';
            
            } else break;

        }

        // Проверяем, существует ли нужная нам директории. Если нет, то
        // пытаемся её создать. Если создать не получается,
        // выбрасываем исключение.
        if (!file_exists($this->directory)) {

            if (!mkdir($this->directory)) throw new SaintNestorException('Saint Nestor: "'.$this->directory.'" directory creation failure.', -99);

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
