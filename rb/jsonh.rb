=begin
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
=end

require 'json'

module JSONH
  module_function

  def dump(obj)
    pack(obj).to_json
  end

  def load(str)
    unpack(JSON.load(str))
  end

  def pack(hlist)
    return [] if hlist.empty?
    keys = hlist.first.keys
    [keys.size, *keys, *hlist.map(&:values).flatten(1)]
  end

  def unpack(hlist)
    ksize = Integer(hlist[0])
    keys = hlist[1, ksize]
    values = hlist[ksize+1..-1]
    values.each_slice(ksize).map do |values|
      Hash[keys.zip(values)]
    end
  end
end

if $0 == __FILE__
  require 'bacon'
  Bacon.summary_on_exit

  describe JSONH do
    collection = [
      {'a' => 'A', 'b' => 'B'},
      {'a' => 'C', 'b' => 'D'},
      {'a' => 'E', 'b' => 'F'}
    ]

    json = %([2,"a","b","A","B","C","D","E","F"])

    it 'dumps homogenous collections' do
      JSONH.dump(collection).should == json
    end

    it 'loads homogenous collections' do
      JSONH.load(json).should == collection
    end
  end
end
