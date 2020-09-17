<?php
/**
 *    Saint Nestor ver. 2.0
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
        $this->log(7, $message, $context);
    }

    public function alert(string $message, array $context = [])
    {
        $this->log(6, $message, $context);
    }

    public function critical(string $message, array $context = [])
    {
        $this->log(5, $message, $context);
    }

    public function error(string $message, array $context = [])
    {
        $this->log(4, $message, $context);
    }

    public function warning(string $message, array $context = [])
    {
        $this->log(3, $message, $context);
    }

    public function notice(string $message, array $context = [])
    {
        $this->log(2, $message, $context);
    }

    public function info(string $message, array $context = [])
    {
        $this->log(1, $message, $context);
    }

    public function debug(string $message, array $context = [])
    {
        $this->log(0, $message, $context);
    }

    public function log(int $level, string $message, array $context = [])
    {

        // Минимальный уровень — 0, максимальный — 7.
        // Если был указан уровень, лежащий за рамками диапазона от 0 до 7,
        // то приводим его к ближайшему из диапазона.
        if ($level < 0) $level = 0;
        elseif ($level > 7) $level = 7;

        // Определяем текстовое отображение уровня.
        $level_text = '';

        switch ($level) {
            case 0:
                $level_text = LogLevel::DEBUG;
                break;

            case 1:
                $level_text = LogLevel::INFO;
                break;

            case 2:
                $level_text = LogLevel::NOTICE;
                break;

            case 3:
                $level_text = LogLevel::WARNING;
                break;

            case 4:
                $level_text = LogLevel::ERROR;
                break;

            case 5:
                $level_text = LogLevel::CRITICAL;
                break;

            case 6:
                $level_text = LogLevel::ALERT;
                break;

            case 7:
                $level_text = LogLevel::EMERGENCY;
                break;
        }

        // Вставляем контекст в сообщение.
        $message = StringHandler::interpolateContextToMessage($message, $context);

        // Собираем имя файла.
        // Если при создании объекта логгера было указано, что логирование
        // должно быть разделено по уровням, то для каждого уровня создаётся
        // отдельный файл, отличающийся от прочих именем своего уровня
        // перед расширением.
        $filename = $this->filename;

        if ($this->separate_levels) $filename .= '_'.$level_text;
        
        $filename .= $this->file_extension;

        // Проверяем, существует ли файл с данным именем в указанной директории.
        // Если существует, то запоминаем его содержимое.
        if (file_exists($this->directory.$filename)) $content = file_get_contents($this->directory.$filename)."\n";
        else $content = '';

        // Добавляем отформатированное логируемое сообщение к контенту файла.
        $content .= date("Y-m-d H:i:s").' || '.strtoupper($level_text).': '.$message;

        // Записываем/перезаписываем файл.
        file_put_contents($this->directory.$filename, $content);

    }

}
