require 'json'

"""
Copyright (C) 2011

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

def dump(obj)
	return json.dump(pack(obj))
end

def load(str)
	return unpack(json.load(str))
end

def pack(hl)
	length = hl.length
	keys = length && hl.key(0) || []
	klength = keys.length
	result = []
	i = 0
	while i < length
	  o = hl[i]
	  ki = 0
	  while ki < klength
	    result.push(o[keys[ki]])
	    ki += 1
	  end
	  i += 1
	end
	return [klength] + keys + result
end

def unpack(hlist)
	length = hlist.length
	klength = hlist[0]
	result = []
	i = 1 + klength
	while i < length
	  o = Hash.new
	  ki = 0
	  while ki < klength
	    ki += 1
	    o[hlist[ki]] = hlist[i]
	    i += 1
	  end
	  result.push(o)
	end
	return result
end