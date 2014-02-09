<?php

namespace phpoffice;

/*
 * (The MIT License)
 * 
 * Copyright (c) 2012-2014 James Jenner
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

/**
 * Text is a class for representing text as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * Note: it is possible to have blank text, this has no impact other than  
 * memory usage. It is annoying when debuging however.
 *  
 * @todo support colours from the theme. currently one unknown theme value, not sure what to do about that. 
 * @see OfficeDocument 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm	 	 
 */ 
class Text {
    /** format contains no lines */
    const NO_LINES = 0;
    /** format contains one lines */
    const ONE_LINE = 1;
    /** format contains two lines lines */
    const TWO_LINES = 2;

    /** background type of solid */
    const SOLID = 1;
    
    // can the following attributes be private? suspect that they can be
	public $language;
	public $text;
	public $isBolded;
	public $isItalics;
	public $isStrikethrough;
	public $isUnderlined;
	public $underlineType;
	
	public $colour;
	public $fillStyle;
	
	public function __construct($node) {
 	    // setup defaults
		$this->text = '';
		$this->language = '';
		$this->isBolded = false;
		$this->isItalics = false;
		$this->isStrikethrough = false;
		$this->isUnderlined = false;
		$this->underlineType = Text::NO_LINES;
		$this->colour = "000000"; // this should be obtained from ??? presuming black is default for now
		$this->fillStyle = Text::SOLID;

		$this->buildText($node);

	}

	/**
	 * getHTML generates html markup representation of the text
	 *
	 * The generated html will use various tags depending on the nature of the 
	 * text. For example, if the text is bolded then the <strong> tag is 
	 * applied.
	 *	 
	 * @return string the html markup for the text
	 */
	public function getHTML() {
	    $markup = '';

	    // open tags as required 
	    if($this->isBolded) {
	      // add strong tag
	      $markup .= '<strong>'; 
	    }
		if($this->isItalics) {
	      // add emphisis tag
	      $markup .= '<em>'; 
	    } 
		if($this->isStrikethrough) {
	      // add ?? tag
	    } 
		if($this->isUnderlined) {
	      // add span tag with text decoration for underline
	      $markup .= '<span style="text-decoration: underline;">';
	    }

        // add span tag to define color
        $markup .= '<span style="color: #' . $this->colour . ';">';
        
        // TODO: add logic so the style is reused for each
        
		// add the text        
        $markup .= $this->text;

        // add close tag for colour applicatoin
        $markup .= '</span>';

        // close tags as required
	    if($this->isBolded) {
	      // add close strong tag
	      $markup .= '</strong>'; 
	    }
		if($this->isItalics) {
	      // add close emphisis tag
	      $markup .= '</em>'; 
	    } 
		if($this->isStrikethrough) {
	      // add close ?? tag 
	    } 
		if($this->isUnderlined) {
	      // add close span tag
	      $markup .= '</span>';
	    }

		return $markup;
	}	 

	/**
	 * buildText build the text based on the specified node
	 * 
	 * @param node a node that represents the text	 
	 * @see Text	 	 
	 */ 
	private function buildText($textRunNode) {
		// populate the text, do we need this?		
        // $this->text = (string)$node->children("a", TRUE)->t;
        // echo " --- style " .

        foreach($textRunNode->children("a", TRUE) as $childNode) {
	        if($childNode->getName() === "t") {
	            // we have text
	            $this->text = (string)$childNode; 
			} else if($childNode->getName() === "rPr") {
				// we have properties
			    $attributes = $childNode->attributes();
			    if((string)$attributes->b === '1') {
			        $this->isBolded = true;
		        }
			    if((string)$attributes->i === '1') {
	                $this->isItalics = true;
		        }
			    if((string)$attributes->u === 'sng') {
			        $this->isUnderlined = true;
			        $this->underlineType = Text::ONE_LINE;
			    }
			    if((string)$attributes->u === 'dbl') {
			        $this->isUnderlined = true;
			        $this->underlineType = Text::TWO_LINES;
			    }
			    if((string)$attributes->strike === 'sngStrike') {
				    $this->Strikethrough = true;
			    }
			    if(isset($attributes->lang)) {
			        $this->language = (string)$attributes->lang;
			    }
			    foreach($childNode->children("a", TRUE) as $node2) {
			        if((string)$node2->getName() === "solidFill") {
			            $this->fillStyle = Text::SOLID;
						 
	                    foreach($node2->children("a", TRUE) as $node3) {
	                        $attr = $node3->attributes();
	                        
	                        if($node3->getName() === "schemeClr") {
	                          echo "Scheme colour: " . $attr->val . " ";
	                          // TODO: insert logic to handle colours from scheme
	                          // ideally the actual colour should be added from
	                          // the theme, but that means processing the 
	                          // 
							} else if($node3->getName() === "srgbClr") {
			                  $this->colour = (string)$attr->val;
							}
	                    }
					}
				}
			}
        }
	}
}

?>
