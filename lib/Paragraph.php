<?php

namespace phpoffice;

use phpoffice\Text;

use phpoffice\powerpoint\ParagraphProperty;

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
 * Paragraph is a class for representing a paragraph as per the Office Open XML File Formats, Standard ECMA-376
 *
 * Please note the following:
 * By default a paragraph uses bullets, a paragraph has no bullets only if the bullet none type is specified. 
 * The start for auto bullets are duplicated for each paragraph until the bullet type or style is changed. This can 
 * be misleading as the count doesn't restart on the next instance.  
 *   
 * @todo determine how consecutive same numbers for start at are handled.    
 *  
 * @todo implement fully the specification for paragraphs 
 * @see OfficeDocument 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm	 	 
 */ 
class Paragraph {
    // can the following attributes be private? suspect that they can be
    
    /** the Text object instance for the Paragraph instance @see Text */
	public $text;
	/** a paragraph property instance for the paragraph */
	public $paragraphProperty;

	/**
	 * constructor for the Paragraph class
	 * 
	 * @param node the node for the paragraph based on Office Open XML File Formats, Standard ECMA-376 
	 */	 		
	public function __construct($node) {
        // apply defaults
        $this->text = array();
        $this->paragraphProperty = new ParagraphProperty($this);
        // build the paragraph
		$this->buildParagraph($node);
	}

	/**
	 * getHTML retreives from all components of the paragraph instance producing a html markup representation of the paragraph
	 *
	 * The generated html will use various tags depending on the nature of the 
	 * paragraph. For example, if the paragraph is a list of auto numbers then 
	 * the ordered list <ol> tag is applied, while if the paragraph is text 
	 * then the paragraph <p> tag will be applied.
	 * Attributes are added to the encapsulating tag to provide markup for 
	 * indentation, alignment, etc.
	 * 
	 * Note that bullet information is kept in the paragraph property while text is in the paragraph. Due to html constraints
	 * the processing for the bullets is performed here. It is possible to move bullet logic to the ParagraphProperty class, 
	 * however this may make comprehension of how the html markup is generated difficult. 	 	  	 	 	 	 	      	  	 
	 *	 
	 * @param Paragraph $prevParagraph a link to the previous paragraph, this is required for bullet point based sequences 
	 * 	 	 
	 * @return string the html markup for the paragraph
	 */
	public function getHTML($prevParagraph) {
	    $markup = '';

        // note that debuging is left in because uncertain on impact when templates are applied

        // echo "p.getHTML()<br>";
	    // add markup for 
	    if($this->paragraphProperty->bulletStyle == ParagraphProperty::NO_BULLETS) {
	      // no bullets, need to check if bullets have previously been generated, if so then close
	      if(isset($prevParagraph) && $prevParagraph->paragraphProperty->bulletStyle == ParagraphProperty::AUTO_NUMBERED_BULLETS) {
            // close the auto numbered bullets
		    $markup = "</ol>";
            echo "- /ol<br>";
		  } else if (isset($prevParagraph) && $prevParagraph->paragraphProperty->bulletStyle == ParagraphProperty::BULLETS) {
		    // close the bullets
		    $markup = "</ul>";
            echo "- /ul<br>";
		  }
		  
          // add the start pargapraph tag, leave open to allow addition of properties
		  $markup = "<p"; 
          echo "- p (no &gt)<br>";
		} else if($this->paragraphProperty->bulletStyle == ParagraphProperty::AUTO_NUMBERED_BULLETS) {
          // close bullets if prev was bullets
		  if(isset($prevParagraph) && ParagraphProperty::BULLETS) {
            // close prevoius bullets 
            $markup = "</ul>";
		  } else if($prevParagraph->paragraphProperty->bulletStyle == ParagraphProperty::AUTO_NUMBERED_BULLETS && 
		            $prevParagraph->paragraphProperty->bulletStartsAt != $this->paragraphProperty->bulletStartsAt) {
            // if the previous auto bullet started at a different number, then close them
            $markup = '</ol>';
          }
          
		  // start the auto numbered bullets if it's new and set the style of the bullets
	      if(!isset($prevParagraph) || 
		     $prevParagraph->paragraphProperty->bulletStyle != ParagraphProperty::AUTO_NUMBERED_BULLETS ||
		     ($prevParagraph->paragraphProperty->bulletStyle == ParagraphProperty::AUTO_NUMBERED_BULLETS && 
			  $prevParagraph->paragraphProperty->bulletStartsAt != $this->paragraphProperty->bulletStartsAt)) { 

            // open the orderd list start tag            
            $markup .= '<ol';
            // add the start at if it is specified, default is 1, so no need if not set
			if($this->paragraphProperty->bulletStartsAt > 0) {
			  $markup .= ' start=' . $this->paragraphProperty->bulletStartsAt;
	        }
            // add the class, associated style and close the orderd list start tag            
			$markup .= ' class="'. $this->paragraphProperty->getBulletTypeClassDef() . '">';
            
            echo "- ol ". $this->paragraphProperty->bulletStartsAt ."<br>";
          }
          
          // add the start list item tag, leave open to allow addition of properties
		  $markup .= "<li";
          echo "-- li (no &gt)<br>";
		} else if($this->paragraphProperty->bulletStyle == ParagraphProperty::BULLETS) {
          // close auto numbered bullets if prev was auto numbered bullets
		  if(isset($prevParagraph) && ParagraphProperty::AUTO_NUMBERED_BULLETS) {
            // close prevoius bullets
            $markup = "</ol>";
		  }
		  
		  // start the bullets if not previously started
	      if(!isset($prevParagraph) || $prevParagraph->paragraphProperty->bulletStyle != ParagraphProperty::BULLETS) {
            $markup = "<ul>";
            echo "- ul<br>";
          }
          // add the start list item tag, leave open to allow addition of properties
		  $markup .= "<li";
          echo "-- li (no &gt)<br>";
		}

		// apply alignment
        switch($this->paragraphProperty->alignment) {
          default:
          case ParagraphProperty::LEFT:
            $markup .= " align=left";
            echo "--- align left<br>";
            break;
          case ParagraphProperty::CENTER:
            $markup .= " align=center";
            echo "--- align center<br>";
            break;
		  case ParagraphProperty::RIGHT:
            $markup .= " align=right";
            echo "--- align right<br>";
            break;
          case ParagraphProperty::JUSTIFY:
            $markup .= " align=justify";
            echo "--- align justify<br>";
            break;
		}

		// complete the opening tag
        $markup .= ">";
        echo "- &gt<br>";

		// add the text        
		foreach($this->text as $textInstance) {
          $markup .= $textInstance->getHTML();
        }

		// close the pargapraph tag if no bullets
	    if($this->paragraphProperty->bulletStyle == ParagraphProperty::NO_BULLETS) {
	      // add the close paragraph tag
		  $markup .= "</p>";
          echo "/p<br>";
        } else if($this->paragraphProperty->bulletStyle == ParagraphProperty::AUTO_NUMBERED_BULLETS || 
		          $this->paragraphProperty->bulletStyle == ParagraphProperty::BULLETS) {
          // add the close list item tag
		  $markup .= "</li>";
          echo "-- /li<br>";
        }

        // note: presumption is that there will be an empty final paragraph set 
		// to NO_BULLETS to close of any lists, as such it is not handled here

		return $markup;
	}	 	
	 
	/**
	 * process the specified node to build the current instance of the paragraph
	 * 
	 * @param node the node to be processed that represents a paragraph as per the standard
	 * @see Paragraph	 	 
	 */ 
	private function buildParagraph($paragraphNode) {
	    // process the nodes for the paragraph
		foreach($paragraphNode->children("a", TRUE) as $childNode) {
			echo "-> " . $childNode->getName() . "<br>";
			if($childNode->getName() === "r") {
			    // we have a run node, generate the text
	            $this->text[] = new Text($childNode);
			} else if($childNode->getName() === "pPr") {
			    
			    $this->paragraphProperty = new ParagraphProperty($this, $childNode);
			}
		}
	}
}

?>
