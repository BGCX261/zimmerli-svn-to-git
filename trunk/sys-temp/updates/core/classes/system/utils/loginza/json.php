<?php
define('SERVICES_JSON_SLICE',   1);define('SERVICES_JSON_IN_STR',  2);define('SERVICES_JSON_IN_ARR',  3);define('SERVICES_JSON_IN_OBJ',  4);define('SERVICES_JSON_IN_CMT', 5);define('SERVICES_JSON_LOOSE_TYPE', 16);define('SERVICES_JSON_SUPPRESS_ERRORS', 32);class Services_JSON{function Services_JSON($v5ef76d30bf9232902687324b5bfa0bd2 = 0)    {$this->use = $v5ef76d30bf9232902687324b5bfa0bd2;}function utf162utf8($v5ab39c2bd546655547f6101ed91e395e)    {if(function_exists('mb_convert_encoding')) {return mb_convert_encoding($v5ab39c2bd546655547f6101ed91e395e, 'UTF-8', 'UTF-16');}$v4b3a6218bb3e3a7303e8a171a60fcf92 = (ord($v5ab39c2bd546655547f6101ed91e395e{0}) << 8) | ord($v5ab39c2bd546655547f6101ed91e395e{1});switch(true) {case ((0x7F & $v4b3a6218bb3e3a7303e8a171a60fcf92) == $v4b3a6218bb3e3a7303e8a171a60fcf92):                return chr(0x7F & $v4b3a6218bb3e3a7303e8a171a60fcf92);case (0x07FF & $v4b3a6218bb3e3a7303e8a171a60fcf92) == $v4b3a6218bb3e3a7303e8a171a60fcf92:                return chr(0xC0 | (($v4b3a6218bb3e3a7303e8a171a60fcf92 >> 6) & 0x1F))                     . chr(0x80 | ($v4b3a6218bb3e3a7303e8a171a60fcf92 & 0x3F));case (0xFFFF & $v4b3a6218bb3e3a7303e8a171a60fcf92) == $v4b3a6218bb3e3a7303e8a171a60fcf92:                return chr(0xE0 | (($v4b3a6218bb3e3a7303e8a171a60fcf92 >> 12) & 0x0F))                     . chr(0x80 | (($v4b3a6218bb3e3a7303e8a171a60fcf92 >> 6) & 0x3F))                     . chr(0x80 | ($v4b3a6218bb3e3a7303e8a171a60fcf92 & 0x3F));}return '';}function utf82utf16($v30df7f629fcf6b940bcaef5faf2490bb)    {if(function_exists('mb_convert_encoding')) {return mb_convert_encoding($v30df7f629fcf6b940bcaef5faf2490bb, 'UTF-16', 'UTF-8');}switch(strlen($v30df7f629fcf6b940bcaef5faf2490bb)) {case 1:                return $v30df7f629fcf6b940bcaef5faf2490bb;case 2:                return chr(0x07 & (ord($v30df7f629fcf6b940bcaef5faf2490bb{0}) >> 2))                     . chr((0xC0 & (ord($v30df7f629fcf6b940bcaef5faf2490bb{0}) << 6))                         | (0x3F & ord($v30df7f629fcf6b940bcaef5faf2490bb{1})));case 3:                return chr((0xF0 & (ord($v30df7f629fcf6b940bcaef5faf2490bb{0}) << 4))                         | (0x0F & (ord($v30df7f629fcf6b940bcaef5faf2490bb{1}) >> 2)))                     . chr((0xC0 & (ord($v30df7f629fcf6b940bcaef5faf2490bb{1}) << 6))                         | (0x7F & ord($v30df7f629fcf6b940bcaef5faf2490bb{2})));}return '';}function encode($vb2145aac704ce76dbe1ac7adac535b23)    {switch (gettype($vb2145aac704ce76dbe1ac7adac535b23)) {case 'boolean':                return $vb2145aac704ce76dbe1ac7adac535b23 ? 'true' : 'false';case 'NULL':                return 'null';case 'integer':                return (int) $vb2145aac704ce76dbe1ac7adac535b23;case 'double':            case 'float':                return (float) $vb2145aac704ce76dbe1ac7adac535b23;case 'string':                $v5b7f33be48f19c25e1af2f96cffc569f = '';$v37b444b101c7d5959fca2167b4b7ac6b = strlen($vb2145aac704ce76dbe1ac7adac535b23);for ($v4a8a08f09d37b73795649038408b5f33 = 0;$v4a8a08f09d37b73795649038408b5f33 < $v37b444b101c7d5959fca2167b4b7ac6b;++$v4a8a08f09d37b73795649038408b5f33) {$v927f82b1af77cb897fc4548ab65ff12e = ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33});switch (true) {case $v927f82b1af77cb897fc4548ab65ff12e == 0x08:                            $v5b7f33be48f19c25e1af2f96cffc569f .= '\b';break;case $v927f82b1af77cb897fc4548ab65ff12e == 0x09:                            $v5b7f33be48f19c25e1af2f96cffc569f .= '\t';break;case $v927f82b1af77cb897fc4548ab65ff12e == 0x0A:                            $v5b7f33be48f19c25e1af2f96cffc569f .= '\n';break;case $v927f82b1af77cb897fc4548ab65ff12e == 0x0C:                            $v5b7f33be48f19c25e1af2f96cffc569f .= '\f';break;case $v927f82b1af77cb897fc4548ab65ff12e == 0x0D:                            $v5b7f33be48f19c25e1af2f96cffc569f .= '\r';break;case $v927f82b1af77cb897fc4548ab65ff12e == 0x22:                        case $v927f82b1af77cb897fc4548ab65ff12e == 0x2F:                        case $v927f82b1af77cb897fc4548ab65ff12e == 0x5C:                            $v5b7f33be48f19c25e1af2f96cffc569f .= '\\'.$vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33};break;case (($v927f82b1af77cb897fc4548ab65ff12e >= 0x20) && ($v927f82b1af77cb897fc4548ab65ff12e <= 0x7F)):                            $v5b7f33be48f19c25e1af2f96cffc569f .= $vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33};break;case (($v927f82b1af77cb897fc4548ab65ff12e & 0xE0) == 0xC0):                            $va87deb01c5f539e6bda34829c8ef2368 = pack('C*', $v927f82b1af77cb897fc4548ab65ff12e, ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 1}));$v4a8a08f09d37b73795649038408b5f33 += 1;$v5ab39c2bd546655547f6101ed91e395e = $this->utf82utf16($va87deb01c5f539e6bda34829c8ef2368);$v5b7f33be48f19c25e1af2f96cffc569f .= sprintf('\u%04s', bin2hex($v5ab39c2bd546655547f6101ed91e395e));break;case (($v927f82b1af77cb897fc4548ab65ff12e & 0xF0) == 0xE0):                            $va87deb01c5f539e6bda34829c8ef2368 = pack('C*', $v927f82b1af77cb897fc4548ab65ff12e,                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 1}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 2}));$v4a8a08f09d37b73795649038408b5f33 += 2;$v5ab39c2bd546655547f6101ed91e395e = $this->utf82utf16($va87deb01c5f539e6bda34829c8ef2368);$v5b7f33be48f19c25e1af2f96cffc569f .= sprintf('\u%04s', bin2hex($v5ab39c2bd546655547f6101ed91e395e));break;case (($v927f82b1af77cb897fc4548ab65ff12e & 0xF8) == 0xF0):                            $va87deb01c5f539e6bda34829c8ef2368 = pack('C*', $v927f82b1af77cb897fc4548ab65ff12e,                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 1}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 2}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 3}));$v4a8a08f09d37b73795649038408b5f33 += 3;$v5ab39c2bd546655547f6101ed91e395e = $this->utf82utf16($va87deb01c5f539e6bda34829c8ef2368);$v5b7f33be48f19c25e1af2f96cffc569f .= sprintf('\u%04s', bin2hex($v5ab39c2bd546655547f6101ed91e395e));break;case (($v927f82b1af77cb897fc4548ab65ff12e & 0xFC) == 0xF8):                            $va87deb01c5f539e6bda34829c8ef2368 = pack('C*', $v927f82b1af77cb897fc4548ab65ff12e,                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 1}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 2}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 3}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 4}));$v4a8a08f09d37b73795649038408b5f33 += 4;$v5ab39c2bd546655547f6101ed91e395e = $this->utf82utf16($va87deb01c5f539e6bda34829c8ef2368);$v5b7f33be48f19c25e1af2f96cffc569f .= sprintf('\u%04s', bin2hex($v5ab39c2bd546655547f6101ed91e395e));break;case (($v927f82b1af77cb897fc4548ab65ff12e & 0xFE) == 0xFC):                            $va87deb01c5f539e6bda34829c8ef2368 = pack('C*', $v927f82b1af77cb897fc4548ab65ff12e,                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 1}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 2}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 3}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 4}),                                         ord($vb2145aac704ce76dbe1ac7adac535b23{$v4a8a08f09d37b73795649038408b5f33 + 5}));$v4a8a08f09d37b73795649038408b5f33 += 5;$v5ab39c2bd546655547f6101ed91e395e = $this->utf82utf16($va87deb01c5f539e6bda34829c8ef2368);$v5b7f33be48f19c25e1af2f96cffc569f .= sprintf('\u%04s', bin2hex($v5ab39c2bd546655547f6101ed91e395e));break;}}return '"'.$v5b7f33be48f19c25e1af2f96cffc569f.'"';case 'array':               if (is_array($vb2145aac704ce76dbe1ac7adac535b23) && count($vb2145aac704ce76dbe1ac7adac535b23) && (array_keys($vb2145aac704ce76dbe1ac7adac535b23) !== range(0, sizeof($vb2145aac704ce76dbe1ac7adac535b23) - 1))) {$v74693d2fc58b46bd06410f278e39aa71 = array_map(array($this, 'name_value'),                                            array_keys($vb2145aac704ce76dbe1ac7adac535b23),                                            array_values($vb2145aac704ce76dbe1ac7adac535b23));foreach($v74693d2fc58b46bd06410f278e39aa71 as $v1a8db4c996d8ed8289da5f957879ab94) {if(Services_JSON::isError($v1a8db4c996d8ed8289da5f957879ab94)) {return $v1a8db4c996d8ed8289da5f957879ab94;}}return '{' . join(',', $v74693d2fc58b46bd06410f278e39aa71) . '}';}$v6a7f245843454cf4f28ad7c5e2572aa2 = array_map(array($this, 'encode'), $vb2145aac704ce76dbe1ac7adac535b23);foreach($v6a7f245843454cf4f28ad7c5e2572aa2 as $v8e2dcfd7e7e24b1ca76c1193f645902b) {if(Services_JSON::isError($v8e2dcfd7e7e24b1ca76c1193f645902b)) {return $v8e2dcfd7e7e24b1ca76c1193f645902b;}}return '[' . join(',', $v6a7f245843454cf4f28ad7c5e2572aa2) . ']';case 'object':                $vb63119da730344b345cdc8f62a4711e9 = get_object_vars($vb2145aac704ce76dbe1ac7adac535b23);$v74693d2fc58b46bd06410f278e39aa71 = array_map(array($this, 'name_value'),                                        array_keys($vb63119da730344b345cdc8f62a4711e9),                                        array_values($vb63119da730344b345cdc8f62a4711e9));foreach($v74693d2fc58b46bd06410f278e39aa71 as $v1a8db4c996d8ed8289da5f957879ab94) {if(Services_JSON::isError($v1a8db4c996d8ed8289da5f957879ab94)) {return $v1a8db4c996d8ed8289da5f957879ab94;}}return '{' . join(',', $v74693d2fc58b46bd06410f278e39aa71) . '}';default:                return ($this->use & SERVICES_JSON_SUPPRESS_ERRORS)                    ? 'null'                    : new Services_JSON_Error(gettype($vb2145aac704ce76dbe1ac7adac535b23)." can not be encoded as JSON string");}}function name_value($vb068931cc450442b63f5b3d276ea4297, $v2063c1608d6e0baf80249c42e2be5804)    {$v2e30bd0e89df19bd6f60f7bdc44231bb = $this->encode($v2063c1608d6e0baf80249c42e2be5804);if(Services_JSON::isError($v2e30bd0e89df19bd6f60f7bdc44231bb)) {return $v2e30bd0e89df19bd6f60f7bdc44231bb;}return $this->encode(strval($vb068931cc450442b63f5b3d276ea4297)) . ':' . $v2e30bd0e89df19bd6f60f7bdc44231bb;}function reduce_string($v341be97d9aff90c9978347f66f945b77)    {$v341be97d9aff90c9978347f66f945b77 = preg_replace(array(                '#^\s*//(.+)$#m',                '#^\s*/\*(.+)\*/#Us',                '#/\*(.+)\*/\s*$#Us'            ), '', $v341be97d9aff90c9978347f66f945b77);return trim($v341be97d9aff90c9978347f66f945b77);}function decode($v341be97d9aff90c9978347f66f945b77)    {$v341be97d9aff90c9978347f66f945b77 = $this->reduce_string($v341be97d9aff90c9978347f66f945b77);switch (strtolower($v341be97d9aff90c9978347f66f945b77)) {case 'true':                return true;case 'false':                return false;case 'null':                return null;default:                $v6f8f57715090da2632453988d9a1501b = array();if (is_numeric($v341be97d9aff90c9978347f66f945b77)) {return ((float)$v341be97d9aff90c9978347f66f945b77 == (integer)$v341be97d9aff90c9978347f66f945b77)                        ? (integer)$v341be97d9aff90c9978347f66f945b77                        : (float)$v341be97d9aff90c9978347f66f945b77;}elseif (preg_match('/^("|\').*(\1)$/s', $v341be97d9aff90c9978347f66f945b77, $v6f8f57715090da2632453988d9a1501b) && $v6f8f57715090da2632453988d9a1501b[1] == $v6f8f57715090da2632453988d9a1501b[2]) {$v7139a624d88470cfc0cdf3552644e4f3 = substr($v341be97d9aff90c9978347f66f945b77, 0, 1);$v5fe96590c7e52f9440570f372d519d38 = substr($v341be97d9aff90c9978347f66f945b77, 1, -1);$v30df7f629fcf6b940bcaef5faf2490bb = '';$v9a5df70113640ec360a29ef74c4533b1 = strlen($v5fe96590c7e52f9440570f372d519d38);for ($v4a8a08f09d37b73795649038408b5f33 = 0;$v4a8a08f09d37b73795649038408b5f33 < $v9a5df70113640ec360a29ef74c4533b1;++$v4a8a08f09d37b73795649038408b5f33) {$vb2b45262d21ec6fc5df1fc155ecfeb39 = substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 2);$v7874d5c37f520aaa756c18db557d38e9 = ord($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33});switch (true) {case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\b':                                $v30df7f629fcf6b940bcaef5faf2490bb .= chr(0x08);++$v4a8a08f09d37b73795649038408b5f33;break;case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\t':                                $v30df7f629fcf6b940bcaef5faf2490bb .= chr(0x09);++$v4a8a08f09d37b73795649038408b5f33;break;case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\n':                                $v30df7f629fcf6b940bcaef5faf2490bb .= chr(0x0A);++$v4a8a08f09d37b73795649038408b5f33;break;case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\f':                                $v30df7f629fcf6b940bcaef5faf2490bb .= chr(0x0C);++$v4a8a08f09d37b73795649038408b5f33;break;case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\r':                                $v30df7f629fcf6b940bcaef5faf2490bb .= chr(0x0D);++$v4a8a08f09d37b73795649038408b5f33;break;case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\\"':                            case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\\\'':                            case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\\\\':                            case $vb2b45262d21ec6fc5df1fc155ecfeb39 == '\\/':                                if (($v7139a624d88470cfc0cdf3552644e4f3 == '"' && $vb2b45262d21ec6fc5df1fc155ecfeb39 != '\\\'') ||                                   ($v7139a624d88470cfc0cdf3552644e4f3 == "'" && $vb2b45262d21ec6fc5df1fc155ecfeb39 != '\\"')) {$v30df7f629fcf6b940bcaef5faf2490bb .= $v5fe96590c7e52f9440570f372d519d38{++$v4a8a08f09d37b73795649038408b5f33};}break;case preg_match('/\\\u[0-9A-F]{4}/i', substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 6)):                                $v5ab39c2bd546655547f6101ed91e395e = chr(hexdec(substr($v5fe96590c7e52f9440570f372d519d38, ($v4a8a08f09d37b73795649038408b5f33 + 2), 2)))                                       . chr(hexdec(substr($v5fe96590c7e52f9440570f372d519d38, ($v4a8a08f09d37b73795649038408b5f33 + 4), 2)));$v30df7f629fcf6b940bcaef5faf2490bb .= $this->utf162utf8($v5ab39c2bd546655547f6101ed91e395e);$v4a8a08f09d37b73795649038408b5f33 += 5;break;case ($v7874d5c37f520aaa756c18db557d38e9 >= 0x20) && ($v7874d5c37f520aaa756c18db557d38e9 <= 0x7F):                                $v30df7f629fcf6b940bcaef5faf2490bb .= $v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33};break;case ($v7874d5c37f520aaa756c18db557d38e9 & 0xE0) == 0xC0:                                $v30df7f629fcf6b940bcaef5faf2490bb .= substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 2);++$v4a8a08f09d37b73795649038408b5f33;break;case ($v7874d5c37f520aaa756c18db557d38e9 & 0xF0) == 0xE0:                                $v30df7f629fcf6b940bcaef5faf2490bb .= substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 3);$v4a8a08f09d37b73795649038408b5f33 += 2;break;case ($v7874d5c37f520aaa756c18db557d38e9 & 0xF8) == 0xF0:                                $v30df7f629fcf6b940bcaef5faf2490bb .= substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 4);$v4a8a08f09d37b73795649038408b5f33 += 3;break;case ($v7874d5c37f520aaa756c18db557d38e9 & 0xFC) == 0xF8:                                $v30df7f629fcf6b940bcaef5faf2490bb .= substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 5);$v4a8a08f09d37b73795649038408b5f33 += 4;break;case ($v7874d5c37f520aaa756c18db557d38e9 & 0xFE) == 0xFC:                                $v30df7f629fcf6b940bcaef5faf2490bb .= substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 6);$v4a8a08f09d37b73795649038408b5f33 += 5;break;}}return $v30df7f629fcf6b940bcaef5faf2490bb;}elseif (preg_match('/^\[.*\]$/s', $v341be97d9aff90c9978347f66f945b77) || preg_match('/^\{.*\}$/s', $v341be97d9aff90c9978347f66f945b77)) {if ($v341be97d9aff90c9978347f66f945b77{0}== '[') {$v4398dcfde97e17c14e5628a8f8520cca = array(SERVICES_JSON_IN_ARR);$v47c80780ab608cc046f2a6e6f071feb6 = array();}else {if ($this->use & SERVICES_JSON_LOOSE_TYPE) {$v4398dcfde97e17c14e5628a8f8520cca = array(SERVICES_JSON_IN_OBJ);$vbe8f80182e0c983916da7338c2c1c040 = array();}else {$v4398dcfde97e17c14e5628a8f8520cca = array(SERVICES_JSON_IN_OBJ);$vbe8f80182e0c983916da7338c2c1c040 = new stdClass();}}array_push($v4398dcfde97e17c14e5628a8f8520cca, array('what'  => SERVICES_JSON_SLICE,                                           'where' => 0,                                           'delim' => false));$v5fe96590c7e52f9440570f372d519d38 = substr($v341be97d9aff90c9978347f66f945b77, 1, -1);$v5fe96590c7e52f9440570f372d519d38 = $this->reduce_string($v5fe96590c7e52f9440570f372d519d38);if ($v5fe96590c7e52f9440570f372d519d38 == '') {if (reset($v4398dcfde97e17c14e5628a8f8520cca) == SERVICES_JSON_IN_ARR) {return $v47c80780ab608cc046f2a6e6f071feb6;}else {return $vbe8f80182e0c983916da7338c2c1c040;}}$v9a5df70113640ec360a29ef74c4533b1 = strlen($v5fe96590c7e52f9440570f372d519d38);for ($v4a8a08f09d37b73795649038408b5f33 = 0;$v4a8a08f09d37b73795649038408b5f33 <= $v9a5df70113640ec360a29ef74c4533b1;++$v4a8a08f09d37b73795649038408b5f33) {$vb28354b543375bfa94dabaeda722927f = end($v4398dcfde97e17c14e5628a8f8520cca);$vb2b45262d21ec6fc5df1fc155ecfeb39 = substr($v5fe96590c7e52f9440570f372d519d38, $v4a8a08f09d37b73795649038408b5f33, 2);if (($v4a8a08f09d37b73795649038408b5f33 == $v9a5df70113640ec360a29ef74c4533b1) || (($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== ',') && ($vb28354b543375bfa94dabaeda722927f['what'] == SERVICES_JSON_SLICE))) {$v6d52012dca4fc77aa554f25430aef501 = substr($v5fe96590c7e52f9440570f372d519d38, $vb28354b543375bfa94dabaeda722927f['where'], ($v4a8a08f09d37b73795649038408b5f33 - $vb28354b543375bfa94dabaeda722927f['where']));array_push($v4398dcfde97e17c14e5628a8f8520cca, array('what' => SERVICES_JSON_SLICE, 'where' => ($v4a8a08f09d37b73795649038408b5f33 + 1), 'delim' => false));if (reset($v4398dcfde97e17c14e5628a8f8520cca) == SERVICES_JSON_IN_ARR) {array_push($v47c80780ab608cc046f2a6e6f071feb6, $this->decode($v6d52012dca4fc77aa554f25430aef501));}elseif (reset($v4398dcfde97e17c14e5628a8f8520cca) == SERVICES_JSON_IN_OBJ) {$v78f0805fa8ffadabda721fdaf85b3ca9 = array();if (preg_match('/^\s*(["\'].*[^\\\]["\'])\s*:\s*(\S.*),?$/Uis', $v6d52012dca4fc77aa554f25430aef501, $v78f0805fa8ffadabda721fdaf85b3ca9)) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $this->decode($v78f0805fa8ffadabda721fdaf85b3ca9[1]);$v3a6d0284e743dc4a9b86f97d6dd1a3bf = $this->decode($v78f0805fa8ffadabda721fdaf85b3ca9[2]);if ($this->use & SERVICES_JSON_LOOSE_TYPE) {$vbe8f80182e0c983916da7338c2c1c040[$v3c6e0b8a9c15224a8228b9a98ca1531d] = $v3a6d0284e743dc4a9b86f97d6dd1a3bf;}else {$vbe8f80182e0c983916da7338c2c1c040->$v3c6e0b8a9c15224a8228b9a98ca1531d = $v3a6d0284e743dc4a9b86f97d6dd1a3bf;}}elseif (preg_match('/^\s*(\w+)\s*:\s*(\S.*),?$/Uis', $v6d52012dca4fc77aa554f25430aef501, $v78f0805fa8ffadabda721fdaf85b3ca9)) {$v3c6e0b8a9c15224a8228b9a98ca1531d = $v78f0805fa8ffadabda721fdaf85b3ca9[1];$v3a6d0284e743dc4a9b86f97d6dd1a3bf = $this->decode($v78f0805fa8ffadabda721fdaf85b3ca9[2]);if ($this->use & SERVICES_JSON_LOOSE_TYPE) {$vbe8f80182e0c983916da7338c2c1c040[$v3c6e0b8a9c15224a8228b9a98ca1531d] = $v3a6d0284e743dc4a9b86f97d6dd1a3bf;}else {$vbe8f80182e0c983916da7338c2c1c040->$v3c6e0b8a9c15224a8228b9a98ca1531d = $v3a6d0284e743dc4a9b86f97d6dd1a3bf;}}}}elseif ((($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== '"') || ($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== "'")) && ($vb28354b543375bfa94dabaeda722927f['what'] != SERVICES_JSON_IN_STR)) {array_push($v4398dcfde97e17c14e5628a8f8520cca, array('what' => SERVICES_JSON_IN_STR, 'where' => $v4a8a08f09d37b73795649038408b5f33, 'delim' => $v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}));}elseif (($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== $vb28354b543375bfa94dabaeda722927f['delim']) &&                                 ($vb28354b543375bfa94dabaeda722927f['what'] == SERVICES_JSON_IN_STR) &&                                 ((strlen(substr($v5fe96590c7e52f9440570f372d519d38, 0, $v4a8a08f09d37b73795649038408b5f33)) - strlen(rtrim(substr($v5fe96590c7e52f9440570f372d519d38, 0, $v4a8a08f09d37b73795649038408b5f33), '\\'))) % 2 != 1)) {array_pop($v4398dcfde97e17c14e5628a8f8520cca);}elseif (($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== '[') &&                                 in_array($vb28354b543375bfa94dabaeda722927f['what'], array(SERVICES_JSON_SLICE, SERVICES_JSON_IN_ARR, SERVICES_JSON_IN_OBJ))) {array_push($v4398dcfde97e17c14e5628a8f8520cca, array('what' => SERVICES_JSON_IN_ARR, 'where' => $v4a8a08f09d37b73795649038408b5f33, 'delim' => false));}elseif (($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== ']') && ($vb28354b543375bfa94dabaeda722927f['what'] == SERVICES_JSON_IN_ARR)) {array_pop($v4398dcfde97e17c14e5628a8f8520cca);}elseif (($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== '{') &&                                 in_array($vb28354b543375bfa94dabaeda722927f['what'], array(SERVICES_JSON_SLICE, SERVICES_JSON_IN_ARR, SERVICES_JSON_IN_OBJ))) {array_push($v4398dcfde97e17c14e5628a8f8520cca, array('what' => SERVICES_JSON_IN_OBJ, 'where' => $v4a8a08f09d37b73795649038408b5f33, 'delim' => false));}elseif (($v5fe96590c7e52f9440570f372d519d38{$v4a8a08f09d37b73795649038408b5f33}== '}') && ($vb28354b543375bfa94dabaeda722927f['what'] == SERVICES_JSON_IN_OBJ)) {array_pop($v4398dcfde97e17c14e5628a8f8520cca);}elseif (($vb2b45262d21ec6fc5df1fc155ecfeb39 == '/*') &&                                 in_array($vb28354b543375bfa94dabaeda722927f['what'], array(SERVICES_JSON_SLICE, SERVICES_JSON_IN_ARR, SERVICES_JSON_IN_OBJ))) {array_push($v4398dcfde97e17c14e5628a8f8520cca, array('what' => SERVICES_JSON_IN_CMT, 'where' => $v4a8a08f09d37b73795649038408b5f33, 'delim' => false));$v4a8a08f09d37b73795649038408b5f33++;}elseif (($vb2b45262d21ec6fc5df1fc155ecfeb39 == '*/') && ($vb28354b543375bfa94dabaeda722927f['what'] == SERVICES_JSON_IN_CMT)) {array_pop($v4398dcfde97e17c14e5628a8f8520cca);$v4a8a08f09d37b73795649038408b5f33++;for ($v865c0c0b4ab0e063e5caa3387c1a8741 = $vb28354b543375bfa94dabaeda722927f['where'];$v865c0c0b4ab0e063e5caa3387c1a8741 <= $v4a8a08f09d37b73795649038408b5f33;++$v865c0c0b4ab0e063e5caa3387c1a8741)                                $v5fe96590c7e52f9440570f372d519d38 = substr_replace($v5fe96590c7e52f9440570f372d519d38, ' ', $v865c0c0b4ab0e063e5caa3387c1a8741, 1);}}if (reset($v4398dcfde97e17c14e5628a8f8520cca) == SERVICES_JSON_IN_ARR) {return $v47c80780ab608cc046f2a6e6f071feb6;}elseif (reset($v4398dcfde97e17c14e5628a8f8520cca) == SERVICES_JSON_IN_OBJ) {return $vbe8f80182e0c983916da7338c2c1c040;}}}}function isError($v8d777f385d3dfec8815d20f7496026dc, $vc13367945d5d4c91047b3b50234aa7ab = null)    {if (class_exists('pear')) {return PEAR::isError($v8d777f385d3dfec8815d20f7496026dc, $vc13367945d5d4c91047b3b50234aa7ab);}elseif (is_object($v8d777f385d3dfec8815d20f7496026dc) && (get_class($v8d777f385d3dfec8815d20f7496026dc) == 'services_json_error' ||                                 is_subclass_of($v8d777f385d3dfec8815d20f7496026dc, 'services_json_error'))) {return true;}return false;}}if (class_exists('PEAR_Error')) {class Services_JSON_Error extends PEAR_Error    {function Services_JSON_Error($v78e731027d8fd50ed642340b7c9a63b3 = 'unknown error', $vc13367945d5d4c91047b3b50234aa7ab = null,                                     $v15d61712450a686a7f365adf4fef581f = null, $v93da65a9fd0004d9477aeac024e08e15 = null, $vd0c0bc7b1930e34f5faf4666533189a2 = null)        {parent::PEAR_Error($v78e731027d8fd50ed642340b7c9a63b3, $vc13367945d5d4c91047b3b50234aa7ab, $v15d61712450a686a7f365adf4fef581f, $v93da65a9fd0004d9477aeac024e08e15, $vd0c0bc7b1930e34f5faf4666533189a2);}}}else {class Services_JSON_Error    {function Services_JSON_Error($v78e731027d8fd50ed642340b7c9a63b3 = 'unknown error', $vc13367945d5d4c91047b3b50234aa7ab = null,                                     $v15d61712450a686a7f365adf4fef581f = null, $v93da65a9fd0004d9477aeac024e08e15 = null, $vd0c0bc7b1930e34f5faf4666533189a2 = null)        {}}}?>
