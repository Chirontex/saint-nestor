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
    public $logging_level;
    public $levels_names;
    public $rigidity;

    const NOTICE = 0;
    const WARNING = 1;
    const ERROR = 2;

    public function __construct(string $logs_dir, bool $rigidity = true)
    {

        $this->logs_dir = $logs_dir;
        $this->rigidity = $rigidity;

        if (!file_exists($this->logs_dir)) {
                
            if (!mkdir($this->logs_dir)) {
                
                if ($this->rigidity) die('Failed to create directory '.$this->logs_dir.'.');
            
            }
        
        }

        $this->log_name_format = '';

        $this->logging_level = 0;

    }

    public function write_log(string $message, int $code, string $custom_filename = '')
    {

        if ($code >= $this->logging_level) {

            $levels_names = $this->levels_names;

            if (!isset($levels_names[0])) $levels_names[0] = 'NOTICE';

            if (!isset($levels_names[1])) $levels_names[1] = 'WARNING';

            if (!isset($levels_names[2])) $levels_names[2] = 'ERROR';

            if (isset($levels_names[$code])) $codename = $levels_names[$code];
            else {

                if ($code > 2) $codename = 'ERROR';
                elseif ($code < 0) $codename = 'NOTICE';

            }

            if (empty($custom_filename)) {

                if (empty($this->log_name_format)) $log_filename = time().'.log';
                else $log_filename = date($this->log_name_format).'.log';

            } else $log_filename = $custom_filename;

            $actual_message = date('Y-m-d H:i:s').' || '.$codename.': '.$message;

            if (file_exists($this->logs_dir.$log_filename)) $log_content = file_get_contents($this->logs_dir.$log_filename)."\n".$actual_message;
            else $log_content = $actual_message;

            if (file_put_contents($this->logs_dir.$log_filename, $log_content)) $result = ['success' => true, 'message' => 'Log written successfully.'];
            else $result = ['success' => false, 'Logging failed.'];

        } else $result = ['success' => false, 'message' => 'Logging level is too high for this log.'];

        return $result;

    }

}
