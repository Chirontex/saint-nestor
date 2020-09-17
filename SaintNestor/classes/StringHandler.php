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

class StringHandler implements StringHandlerInterface
{
    public static function checkStringSymbols(string $string, array $symbols, bool $acceptable_to_find = true)
    {

        // Да, это просто обёртка над двумя следующими методами.
        if ($acceptable_to_find) $result = StringHandler::checkAcceptableSymbols($string, $symbols);
        else $result = StringHandler::checkUnacceptableSymbols($string, $symbols);

        return $result;

    }

    public static function checkAcceptableSymbols(string $string, array $symbols)
    {

        // Проверяем, что строка не является пустой.
        // Если является — возвращаем false, т.к. в проверке пустой строки нет смысла.
        if (iconv_strlen($string) > 0) {

            $result = true;

            // Дробим строку на массив символов для облегчения поиска по ней.
            $string_arr = str_split($string);

            // Заранее все символы из аргумента приводим к строчному типу —
            // опять же, для упрощения поиска.
            foreach ($symbols as $key => $symbol) {
                
                if (!is_string($symbol)) $symbols[$key] = (string)$symbol;

            }

            // Производим проверку.
            // Если нам попадается некорректный символ — прекращаем её и
            // возвращаем false.
            foreach ($string_arr as $symbol) {
                
                if (array_search($symbol, $symbols) === false) {

                    $result = false;
                    break;

                }

            }

        } else $result = false;

        return $result;

    }

    public static function checkUnacceptableSymbols(string $string, array $symbols)
    {

        $result = true;

        // Проверяем, что строка не пустая.
        // В случае данного метода это для нас погоды не делает,
        // на самом деле — если строка пустая, то по умолчанию считаем, что
        // некорректных символов в ней нет, и возвращаем true.
        // Однако идти дальше и даже просто пытаться производить какую-то
        // более глубокую проверку здесь совершенно бессмысленно.
        if (iconv_strlen($string) > 0) {

            // Если неприемлемый символ был найден, то сразу
            // прекращаем проверку и возвращаем false.
            foreach ($symbols as $symbol) {
                    
                $symbol = (string)$symbol;

                if (strpos($string, $symbol) !== false) {

                    $result = false;
                    break;

                }

            }

        }

        return $result;

    }

    public static function interpolateContextToMessage(string $message, array $context)
    {

        // Генерируем массив символов, из которых должны состоять ключи контекста.
        $check = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        $check[] = '_';
        $check[] = '.';
        $check[] = ' ';

        // Проверяем ключ и значение каждого элемента контекста
        // на соответствие требованиям:
        // ключ должен состоять только из символов, содержащихся в $check;
        // значение не должно быть списком, массивом или объектом, не имеющим
        // метод __toString().
        // Если элемент контекста удовлетворяет всем требованиям, то
        // ставим его на место соответствующего плейсхолдера в $message.
        foreach ($context as $key => $value) {
            
            if (StringHandler::checkStringSymbols((string)$key, $check)) {

                if (!is_array($value) && (!is_object($value) || method_exists($value, '__toString'))) {

                    $message = str_replace('{'.$key.'}', (string)$value, $message);

                }

            }

        }

        return $message;

    }

}
