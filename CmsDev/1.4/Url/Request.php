<?php

/**
 * 
 * Example: http://www.website/casas/venta/montevideo
 * 
 * check the request uri: casas/venta/montevideo
 * 
 * //Declarate new Request\get()
 * $Request = new \CmsDev\Request\get();
 * 
 * //Reverse index array, (optional+boolean param), default = true
 * $Request->reverse(false);
 * 
 * // return all string (no reverse mode)
 * echo $Request->all().'<br>';
 * 
 * // return array
 * $allRequest = $Request->all('array');
 * if(count($allRequest)> 1){
 *      echo '$allRequest[1] = '.$allRequest[1].'<br>';
 * }
 * 
 * // return string value of level or false
 * echo 'byLevel(2) = '.$Request->byLevel(2).'<br>';
 * 
 * // return level number or false
 * echo 'byName(\'montevideo\') = on level '.$Request->byName('montevideo').'<br>';
 * 
 * // return boolean, if the second param is the correct level
 * if($Request->byName('casas',3) === true){
 *      echo 'correct :)';
 * }else{
 *      echo 'wrong :(';
 * }
 * 
 * -----------------------------------------
 * Result:
 * -----------------------------------------
 * /casas/venta/montevideo
 * 
 * $allRequest[1] = venta
 * 
 * byLevel(2) = casas
 * 
 * byName('montevideo') = on level 0
 * 
 * wrong :( 
 * -----------------------------------------
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Url;

class Request {

    private $reverse = true;

    private function requestColector($name = 'all', $type = 'all') {
        global $SKT;
        $Count = 0;
        $params = \explode("/", \trim(\str_replace(\SKTURL, '/', $_SERVER['REQUEST_URI']), '/'));
        $all = array();
        if ($this->reverse === true) {
            $params = \array_reverse($params);
        }
        if ($name === 'all') {
            if ($type === 'array' or $type === 'ListArray') {
                foreach ($params AS $key) {
                    if ($key != '') {
                        $all[$Count] = $key;
                        $Count++;
                    }
                }
                return $all;
            } else {
                return $_SERVER['REQUEST_URI'];
            }
        } elseif ($type === 'byName') {
            foreach ($params AS $key) {
                if ($key === $name) {
                    $check = $Count;
                    break;
                } else {
                    $check = false;
                    $Count++;
                }
            }
            return $check;
        } elseif ($type === 'byLevel') {
            $all = $params;
            return $all[$name];
        } else {
            return $_SERVER['REQUEST_URI'];
        }
    }

    /*
     * Return all request string
     */

    public function all($type = '') {
        return self::requestColector('all', $type);
    }

    public static function URL() {
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        $REQUEST_URI = $_SERVER['REQUEST_URI'];
        return $HTTP_HOST . $REQUEST_URI;
    }

    /*
     * return a boolean
     */

    public function byName($name, $validateLevel = false) {
        if ($validateLevel === false) {
            return self::requestColector($name, 'byName');
        } else {
            $level = self::requestColector($name, 'byName');
            if ($level === $validateLevel) {
                return true;
            }
        }
    }

    /*
     * if reverse = true, 0 = last child separate by '/'
     * Return a value string
     */

    public function byLevel($level = 0) {
        return self::requestColector($level, 'byLevel');
    }

    public function reverse($arrayReverse = true) {
        $this->reverse = $arrayReverse;
    }

}

?>
