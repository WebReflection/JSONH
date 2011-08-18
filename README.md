[JSONH](http://webreflection.blogspot.com/2011/08/last-version-of-json-hpack.html) - JSON Homogeneous Collections Compressor
============================================================================================================================

What is JSONH
-------------

JSONH is one of the most performant, yet safe, cross programming language, way to pack and unpack generic homogenous collections.
Based on native or shimmed JSON implementation, JSONH is nothing different than a procedure performed right before `JSON.stringify(data)` or right after `JSON.parse(data)`

[It is demonstrated](http://jsperf.com/jsonh/2) that overall performances of JSONH are up to 3 times faster in compression and 2 times in parsing thanks to smaller and simplified nature of the collection/string.

It is also demonstrated that resulting bandwidth size will be incrementally smaller than equivalent JSON operation reaching, in certain cases, down to 30% of original size and without gzip/deflate compression in place.

JSONH is the latest version of [json.hpack](https://github.com/WebReflection/json.hpack) project and based on [JSONDB concept](http://michaux.ca/articles/json-db-a-compressed-json-format).


What is an Homogenous Collection
--------------------------------

Usually a database result set, stored as list of objects where all of them contains the same amount of keys with identical name.
This is a basic homogeneous collection example: `[{"a":"A","b":"B"},{"a":"C","b":"D"},{"a":"E","b":"F"}]`
We all have exchange over the network one or more homogenous collections at least once.
JSONH is able to pack the example into `[2,"a","b","A","B","C","D","E"]` and unpack it into original collection at light speed.


JSONH is suitable for
---------------------

 * runtime data compression with or without gzip/deflate on both client and server side
 * creation of static JavaScript files to serve in order to save space on Hard Drive and eventually make runtime gzip/deflate compression easier (smaller input)
 * send huge collection of data from the client to the server and improving performances over `JSON.stringify(data)` and required network bandwidth

If the generic object/data contains one or more homogenous collections, JSONH is suitable for these cases too via `pack` and `unpack` operations.
Please read the [related post](http://webreflection.blogspot.com/2011/08/jsonh-and-hybrid-js-objects.html) to know more.


JSONH API
---------
Every implementation is suitable for the programming language code style and every method supports original JSON signature.
As example the JavaScript version is a global `JSONH` object with `stringify`, `parse`, `pack`, and `unpack` methods.

The python version is a module similar to `json` one with current methods: `dump`, `dumps`, `load`, `loads`, `pack`, and `unpack`.

    import jsonh
    
    print(jsonh.dumps(
        [{"a": "A", "b": "B"}, {"a": "C", "b": "D"}, {"a": "E", "b": "F"}],
        separator = (',',':')
    ))


The php 5 version is a static class plus some function in order to let developers decide for their favorite stile.
Extra arguments accepted by `json_encode` and `json_decode` are supported as well.

    require_once('JSONH.class.php');
    
    // classic style
    jsonh_encode($object); // jsonh_decode($object)
    
    // static public stype
    JSONH::stringify($object); // JSONH::parse($object);
    
    // singleton style
    JSONH()->stringify($object); // JSONH()->parse($object)
    

