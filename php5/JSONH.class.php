<?php //5

/**
 * Copyright (C) 2011 by Andrea Giammarchi, @WebReflection
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class JSONH {

    public static function pack(
        /*array /*use type hint if you can removing initial comment*/
        $list
    ) {
        $length = count($list);
        return $length ? (
            is_array($list[0]) ? self::_pack_array($list, $length) : self::_pack_object($list, $length)
        ) : array(0);
    }
    
    public static function parse(
        /*string /*use type hint if you can removing initial comment*/
        $hlist,
        /*boolean /*use type hint if you can removing initial comment*/
        $assoc = false,
        /*int /*use type hint if you can removing initial comment*/
        $depth = 512,
        /*int /*use type hint if you can removing initial comment*/
        $options = 0
    ) {
        return self::unpack(json_decode($hlist, $assoc), $assoc, $depth, $options);
    }
    
    public static function stringify(
        /*array /*use type hint if you can removing initial comment*/
        $list,
        /*int /*use type hint if you can removing initial comment*/
        $options = 0
    ) {
        return json_encode(self::pack($list), $options);
    }
    
    public static function unpack(
        /*array /*use type hint if you can removing initial comment*/
        $hlist,
        /*boolean /*use type hint if you can removing initial comment*/
        $as_array = false
    ) {
        // a ternary operator for each item would have slowed down
        // this is why there are two almost identical methods but don't worry
        // this is not a problem, just a performances boost
        return $as_array ? self::_unpack_array($hlist) : self::_unpack_object($hlist);
    }
    
    private static function _pack_array(
        /*array /*use type hint if you can removing initial comment*/
        $list,
        /*int /*use type hint if you can removing initial comment*/
        $length
    ) {
        for (
            $keys = array_keys($list[0]),
            $klength = count($keys),
            $result = array(),
            $i = 0,
            $j = 0,
            $ki, $o;
            $i < $length; ++$i
        ) {
            for (
                $o = $list[$i], $ki = 0;
                $ki < $klength;
                $result[$j++] = $o[$keys[$ki++]]
            );
        }
        return array_merge(array($klength), $keys, $result);
    }
    
    private static function _pack_object(
        /*object /*use type hint if you can removing initial comment*/
        $list,
        /*int /*use type hint if you can removing initial comment*/
        $length
    ) {
        for (
            $keys = self::_getKeys($list[0]),
            $klength = count($keys),
            $result = array(),
            $i = 0,
            $j = 0,
            $ki, $o;
            $i < $length; ++$i
        ) {
            for (
                $o = $list[$i], $ki = 0;
                $ki < $klength;
                $result[$j++] = $o->$keys[$ki++]
            );
        }
        return array_merge(array($klength), $keys, $result);
    }
    
    private static function _unpack_array(
        /*array /*use type hint if you can removing initial comment*/
        $hlist
    ) {
        for (
            $length = count($hlist),
            $klength = $hlist[0],
            $result = array(),
            $i = 1 + $klength,
            $j = 0,
            $ki, $o;
            $i < $length;
        ) {
            for (
                $o = array(), $ki = 0;
                $ki < $klength;
                $o[$hlist[++$ki]] = $hlist[$i++]
            );
            $result[$j++] = $o;
        }
        return $result;
    }
    
    private static function _unpack_object(
        /*array /*use type hint if you can removing initial comment*/
        $hlist
    ) {
        for (
            $length = count($hlist),
            $klength = $hlist[0],
            $result = array(),
            $i = 1 + $klength,
            $j = 0,
            $ki, $o;
            $i < $length;
        ) {
            for (
                $o = new StdClass, $ki = 0;
                $ki < $klength;
                $o->$hlist[++$ki] = $hlist[$i++]
            );
            $result[$j++] = $o;
        }
        return $result;
    }

    // simple helper
    private static function _getKeys($object) {
        $keys = array();
        foreach ($object as $key => $value) $keys[] = $key;
        return $keys;
    }
    
}

function JSONH() {
    static $JSONH;
    return isset($JSONH) ? $JSONH : $JSONH = new JSONH;
}

function jsonh_encode($object, $options = 0) {
    return JSONH::stringify($object, $options);
}

function jsonh_decode($str, $assoc = false, $depth = 512, $options = 0) {
    return JSONH::parse($str, $assoc, $depth, $options);
}

?>
