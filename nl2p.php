<?php /*
Copyright (c) 2010 Dave Miller

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. */

/**
 * @author Dave Miller
 * @copyright Copyright (c) 2010 Dave Miller
 * @license http://www.dave-miller.com/mit-license MIT License
 */

/**
 * Add <<p>> tags around paragraphs (identified by 2 or more new lines).
 * 
 * Also converts single new lines to <<br />>, unless <var>$nl2br</var> is set to <var>false</var>.
 * 
 * For example, if <var>$content</var> is:
 * 
 * <pre>
 * Hello
 * World.
 * 
 * Hello World.
 * </pre>
 * 
 * Then this:
 * <pre>
 * {$content|escape|nl2p}
 * </pre>
 * 
 * Will output:
 * <pre>
 * &lt;p&gt;Hello&lt;br /&gt;
 * World.&lt;/p>
 * 
 * &lt;p&gt;Hello World.&lt;/p&gt;
 * </pre>
 * 
 * While this:
 * <pre>
 * {$content|escape|nl2p:false}
 * </pre>
 * 
 * Will output:
 * <pre>
 * &lt;p&gt;Hello
 * World.&lt;/p&gt;
 * 
 * &lt;p&gt;Hello World.&lt;/p&gt;
 * </pre>
 * 
 * @param string The input text.
 * @param boolean Whether to convert single new lines to <br />.
 * @return string The linkified text.
 */
function smarty_modifier_nl2p($string, $nl2br = true)
{
    // Normalise new lines
    $string = str_replace(array("\r\n", "\r"), "\n", $string);
    
    // Extract paragraphs
    $parts = explode("\n\n", $string);
    
    // Put them back together again
    $string = '';
    
    foreach ($parts as $part) {
        $part = trim($part);
        if ($part) {
            if ($nl2br) {
                // Convert single new lines to <br />
                $part = nl2br($part);
            }
            $string .= "<p>$part</p>\n\n";
        }
    }
    
    return $string;
}