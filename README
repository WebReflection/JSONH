[JSONH](http://webreflection.blogspot.com/2011/08/last-version-of-json-hpack.html) - JSON Homogeneous Collections Compressor
============================================================================================================================

What is JSONH
-------------

JSONH is one of the most performant, yet safe, way to pack and unpack generic homogenous collections.
Based over native or shimmed JSON implementation, JSONH is nothing different than procedure performed right before `JSON.stringify(data)` or right after `JSON.parse(data)`
[It is demonstrated](http://jsperf.com/jsonh/2) that overall performances of JSONH are up to 3 times faster in compression and 2 times in parsing due simplified nature of the resulted object.
It is also demonstrated that resulting bandwidth size will be incrementally smaller than equivalent JSON operation reaching, in certain cases, down to 30% of original size.
JSONH is the latest version of [json.hpack](https://github.com/WebReflection/json.hpack) project and based on [JSONDB concept](http://michaux.ca/articles/json-db-a-compressed-json-format).


What is an Homogenous Collection
--------------------------------

Usually a database result set, stored as list of objects where all of them contains the same amount of keys with identical name.
This is a basic homogeneous collection example: `[{"a":"A","b":"B"},{"a":"C","b":"D"},{"a":"E","b":"F"}]`
We all have exchange over the network one or more homogenous collections at least once.
JSONH is able to pack the example into `[2,"a","b","A","B","C","D","E"]` and unpack it into original collection at light speed.