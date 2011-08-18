import json

"""
Copyright (C) 2011 by Andrea Giammarchi, @WebReflection

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
"""

def dump(obj, fp, *args, **kwargs):
    return json.dump(pack(obj), fp, *args, **kwargs)

def dumps(obj, *args, **kwargs):
    return json.dumps(pack(obj), *args, **kwargs)

def load(fp, *args, **kwargs):
    return unpack(json.load(fp, *args, **kwargs))

def loads(str, *args, **kwargs):
    return unpack(json.loads(str, *args, **kwargs))

def pack(dict_list):
    length = len(dict_list)
    keys = length and dict_list[0].keys() or []
    klength = len(keys)
    result = []
    i = 0
    while i < length:
        o = dict_list[i]
        ki = 0
        while ki < klength:
            result.append(o[keys[ki]])
            ki = ki + 1
        i = i + 1
    return [klength] + keys + result

def unpack(hlist):
    length = len(hlist)
    klength = hlist[0]
    result = []
    i = 1 + klength
    while i < length:
        o = dict()
        ki = 0
        while ki < klength:
            ki = ki + 1
            o[hlist[ki]] = hlist[i]
            i = i + 1
        result.append(o)
    return result

