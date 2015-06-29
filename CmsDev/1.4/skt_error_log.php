<?php

/**
 * @TODO
 * /home/martind/public_html/ 
 */
/**
 * Description of skt_error_log
 *
 * @author Martín Daguerre
 */

namespace CmsDev;

class skt_error_log {

    public $lines = 0;
    public $logfiles = 0;

    public function infologs() {
        $logs = array();
        $counterror = 0;
        $logs['root'] = $this->get(\SKTPATH, false, 'test');
        $logs['CmsDev'] = $this->get(\SKTPATH_CmsDev, true, 'test');
        $logs['FileSystems'] = $this->get(\SKTPATH_FileSystems, true, 'test');
        $logs['TemplateSite'] = $this->get(\SKTPATH_TemplateSite, true, 'test');
        if ($logs['root'] !== NULL) {
            $this->logfiles++;
        }
        if ($logs['CmsDev'] !== NULL) {
            $this->logfiles++;
        }
        if ($logs['FileSystems'] !== NULL) {
            $this->logfiles++;
        }
        if ($logs['TemplateSite'] !== NULL) {
            $this->logfiles++;
        }
        return $this->logfiles;
    }

    public function get($dir, $recursive = true, $type = 'test') {
        if (is_dir($dir)) {
            if ($gd = opendir($dir)) {
                while (($file = readdir($gd)) !== false) {
                    if ($file != '.' AND $file != '..') {
                        if (is_dir($dir . '/' . $file)) {
                            if ($recursive == true) {
                                self::get($dir . '/' . $file, $recursive, $type);
                            }
                        } else {
                            if (is_file($dir . '/' . $file)) {
                                $size = \filesize($dir . '/' . $file);
                                if ($file == 'error_log') {
                                    if ($type == 'test') {
                                        return 1;
                                    }
                                    if ($type == 'show') {
                                        $this->logfiles++;
                                        $lineA = array();
                                        $line = '';
                                        $loc = $content = '';
                                        $loc = \dirname($dir . '/' . $file) . "/" . $file;
                                        //$content = \nl2br(\file_get_contents($dir . '/' . $file));
                                        //return $this->show($loc, $content);
                                        $file = fopen($dir . '/' . $file, "r");
                                        while (!feof($file)) {
                                            $lineA[] = '<p style="font-size: 14px; white-space: pre-wrap; line-height: 18px;">' . fgets($file) . "</p>";
                                        }
                                        fclose($file);
                                        $linesUnique = array_unique($lineA);
                                        foreach ($linesUnique as $lineU) {
                                            $line.= $lineU;
                                            $this->lines++;
                                        }
                                        return $this->show($loc, 'Errores únicos encontrados: ' . $this->lines . '<br>Líneas totales: ' . count($lineA) . '<br><br>' . $line);
                                    }
                                }
                            }
                        }
                    }
                }
                closedir($gd);
            }
        }
    }

    public function test() {
        return 1;
    }

    public function show($loc, $content) {
        echo '<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $loc . '</h3>'
        . '<div><form method="post">'
        . '<input type="hidden" value="' . $loc . '" name="file">'
        . '<input type="hidden" value="1" name="del">'
        . '<button  type="submit" class="btn btn-danger color-4-i" style="line-height: 20px;"><i class="skt-icon-cancel"></i> Borrar Log: ' . $loc . '</button><br><br>'
        . '</form><pre>' . $content . '</pre></div>';
    }

}
