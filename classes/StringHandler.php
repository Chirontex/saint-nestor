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
    public static function checkStringSymbols(string $string, array $symbols, bool $need_to_find = true)
    {

        // Проверяем длину строки. Если была передана пустая строка,
        // то возвращаем результат, обратный $need_to_find
        if (iconv_strlen($string) > 0) {

            $result = true;

            foreach ($symbols as $symbol) {

                // В массиве может находиться что угодно.
                // Всё принудительно приводим к строке.
                $symbol = (string)$symbol;

                // По $need_to_find определяем, должны быть найдены
                // символы из $symbols или нет.
                // В случае (не)нахождения символа меняем результат на
                // false и завершаем цикл.
                if ($need_to_find) {

                    if (strpos($string, $symbol) === false) {

                        $result = false;
                        break;

                    }

                } else {

                    if (strpos($string, $symbol) !== false) {

                        $result = false;
                        break;

                    }

                }

            }

        } else $result = !$need_to_find;

        return $result;

    }
}
