<?php

namespace phpoffice\powerpoint;

use phpoffice\Paragraph;

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
 * Slide is a class for representing a slide as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * @todo implement fully the specification for slides 
 * @see PowerPoint 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm	 	 
 */ 
class Slide {

    /** the file scheme */
    const FILE_SCHEME = 'zip://';
    /** slide prefix */
    const SLIDE_PREFIX = '#ppt/';

    // TODO: can these be private?

    /** slide id */
	public $id;
    /** slide filename */
	public $filename;
    /** paragraphs within the slide */
	public $paragraphs;


	private $powerpoint;

	public function __construct($powerpoint, $id, $filename) {
		$this->powerpoint = $powerpoint;
		$this->id = $id;
		$this->filename = $filename;
	}

	/**
	 * getHTML retreives from all components of the page instance producing a html markup representation of the page
	 * 	 
	 * @return string the html markup for the page
	 */
	public function getHTML() {
	    $markup = '';
	    $prevParagraph = NULL;
	    // iterate through each paragraph and generate the html markup
        foreach($this->paragraphs as $paragraph) {
            $markup .= $paragraph->getHTML($prevParagraph);
            $prevParagraph = $paragraph;
		}
		
		// TODO: check if there is a memory leak problem due to assigning $paragraph to $prevParagraph
		
		return $markup;
	}	 	

	/**
	 * buildSlide processes the file to generate the slide for the current instance
	 * 
	 * @todo investigate if this should be a private method that is called from the constructor	 	 
	 * 
	 * @param node the node to be processed that represents a paragraph as per the standard
	 * @see Paragraph	 	 
	 */ 
	public function build() {
		// echo "slide: " . $this->filename . "<br>";

		$xml = simplexml_load_file(Slide::FILE_SCHEME . $this->powerpoint->getFile() . Slide::SLIDE_PREFIX . $this->filename);

		if($xml === FALSE) {
			// echo "Error opening file: " . Slide::FILE_SCHEME . $this->powerpoint->getFile() . Slide::SLIDE_PREFIX . $this->filename;
			throw new Exception("Error opening file: " . Slide::FILE_SCHEME . $this->powerpoint->getFile() . Slide::SLIDE_PREFIX . $this->filename);
		}
		
		$zOrderTree = $xml->children('p', TRUE)->cSld->children('p', TRUE)->spTree;
		
		// echo "name : " . $zOrderTree->getName() . "<br>";
		
		foreach($zOrderTree->children("p", TRUE) as $node) {
			
			// echo " - " . $node->getName() . "<br>";
			
			// if the node is a shape
			if($node->getName() === "sp") {
				// echo " -- " . $node->getName() . "<br>";
				
				// we need to get the text bodies
				foreach($node->children("p", TRUE) as $node2) {

					// if the node is a text body
					if($node2->getName() === "txBody") {
						// echo " --- " . $node2->getName() . "<br>";
						
						foreach($node2->children("a", TRUE) as $node3) {

							// if the node is a paragraph
							if($node3->getName() === "p") {
							    // new way
								$this->paragraphs[] = new Paragraph($node3);
							}
						} 
					}
				}
			}
		}
	}
}

?>
