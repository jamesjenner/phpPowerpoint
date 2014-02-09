<?php

namespace phpoffice\powerpoint;

// use phpoffice\Paragraph;


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
 * Shape is a class for representing a shape as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * Shape is used by .
 *  
 * @todo implement fully the specification for shape, if required 
 *  
 * @see PowerPoint 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm
 * @link http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.commonslidedata.aspx 	 	 
 */ 
class Shape {
    /** full size, this is the default size */
    const SIZE_FULL = 0;
    /** half size */
    const SIZE_HALF = 1;
    /** quarter size */
    const SIZE_QUARTER = 2;

    /** date type */
    const TYPE_UNSET = 0;
    /** title type */
    const TYPE_TITLE = 1;
    /** body type */
    const TYPE_BODY = 2;
    /** date type */
    const TYPE_DATE = 3;
    /** footer type */
    const TYPE_FOOTER = 4;
    /** slide number type */
    const TYPE_SLIDE_NUMBER = 5;
    
    /** slide default index value */
    const DEFAULT_INDEX = 0;

	private $node;
	private $parentNode;
	
	/** the id for the shape */
	public $shapeId;
	/** the name of the shape */
	public $name;
	/** the name of the shape */
	public $type;
	/** the size of shape, eg. half, quarter, full */
	public $size;
	/** the index for the shape */
	public $index;
	
	/** the coordinate on the x-axis for the shape */
	public $x;
	/** the coordinate on the y-axis for the shape */
	public $y;
	/** 
	 * the length of the extents rectangle in EMU's - english metric units 
	 * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.extents.aspx 
	 */
	public $cx;
	/** 
	 * the width of the extents rectangle in EMU's - english metric units 
	 * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.extents.aspx 
	 */	 
	public $cy;

	public function __construct($parentNode, $node) {
		$this->parentNode = $parentNode;
		$this->node = $node;
		$this->size = Shape::SIZE_FULL;
		$this->type = Shape::TYPE_UNSET;
		$this->index = Shape::DEFAULT_INDEX;
		
		$this->processShape($node);
	}

	/**
	 * getHTML retreives from all components of the page instance producing a html markup representation of the page
	 * 	 
	 * @return string the html markup for the page
	 */
	public function getHTML() {
	/*
	    $markup = '';
	    $prevParagraph = NULL;
	    // iterate through each paragraph and generate the html markup
        foreach($this->paragraphs as $paragraph) {
            $markup .= $paragraph->getHTML($prevParagraph);
            $prevParagraph = $paragraph;
		}
		
		// TODO: check if there is a memory leak problem due to assigning $paragraph to $prevParagraph
		
		return $markup;
		*/
	}	 	

    /**
     * processShape process the shape node
     * 
     * @param $node the node that represents a shape
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.shape.aspx
     */	     
	private function processShape($node) {
		foreach($node->children("p", TRUE) as $subNode) {
		    echo "----> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
	            case 'nvSpPr':
		            // non visual shape properties 
		            $this->processNonVisualShapeProperties($subNode);
		            break;

	            case 'spPr':
		            // shape properties 
		            $this->processShapeProperties($subNode);
		            break;
    
	            case 'style':
		            // shape style 
		            // @todo: not implemented
		            break;
    
	            case 'txBody':
		            // text body 
    	            // create a new instance of the text body, parsing the current sub node 
		            $this->textBodies[] = new TextBody($this, $subNode);
		            break;

		        case 'extLst':
		            // extension list
		            // @todo: not implemented
		            break;
            }
        }
	}
	
    /**
     * processNonVisualShapeProperties process the non visual shape node
     * 
     * @param $node the node that represents a non visual shape
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.nonvisualshapeproperties.aspx
     */	     
	private function processNonVisualShapeProperties($node) {
		foreach($node->children("p", TRUE) as $subNode) {
		    echo "-----> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
	            case 'cNvPr':
		            // non visual drawing properties
					// todo: confirm that there are no further attributes to process 
		            $attributes = $subNode->attributes();
		            $this->shapeId = (string)$attributes->id;
		            $this->name = (string)$attributes->name;
		            break;
    
	            case 'cNvSpPr':
		            // non visual shape drawing properties 
		            // @todo: not implemented, for the slide master, slide and slide layout it never appears to change
					// most prob only applies to a complexity not currently visible in test slides 
		            // processNonVisualShapeDrawingProperties($subNode);
		            break;
    
	            case 'nvPr':
		            // application non visual drawing properties 
		            $this->processNonVisualDrawingProperties($subNode);
		            break;
            }
		}	
	}
	
	/**
	 * 	processNonVisualDrawingProperties process the non visual drawing properties node
	 * 		 
     * @param $node the node that represents a non visual drawing property
     * 
     * @see processNonVisualShapeProperties
	 */	 
	private function processNonVisualDrawingProperties($node) {
		foreach($node->children("p", TRUE) as $nbrPrSubNode) {
		    if($nbrPrSubNode->getName() === 'ph') {
     		    echo "------> " . $nbrPrSubNode->getName() . "<br>";
		    
		        // retrieve the attributes
		        $attributes = $nbrPrSubNode->attributes();
		        
                // todo: check if there are any other possible attributes
		        // process the index attribute
		        if(isset($attributes->idx)) {
				    $this->index = (int)$attributes->idx;
		        }
		    
		        // process the size attribute
		        switch((string)$attributes->size) {
		            case 'half':
	                    $this->type = Shape::TYPE_BODY;
					    break;
		            case 'qtr':
	                    $this->type = Shape::TYPE_BODY;
					    break;
				}
				
				// process the type attribute
		        switch((string)$attributes->type) {
		            case 'title':
	                    $this->type = Shape::TYPE_TITLE;
	                    break;
		            case 'body':
	                    $this->type = Shape::TYPE_BODY;
	                    break;
		            case 'dt':
	                    $this->type = Shape::TYPE_DATE;
	                    break;
		            case 'ftr':
	                    $this->type = Shape::TYPE_FOOTER;
	                    break;
		            case 'sldNum':
	                    $this->type = Shape::TYPE_SLIDE_NUMBER;
	                    break;
                }
		    }
		}
	}
	
    /**
     * processShapeProperties process the shape properties node
     * 
     * @param $node the node that represents a shape property
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.shapeproperties.aspx
     */	     
	private function processShapeProperties($node) {
	    // retrieve the elements under the transform 2d node (a:xfrm, which is under the shape properties node)
	    
	    // we do not retreive attributes for the xfrm node, currently we're skipping it.
	    // this is because it only provides flipH, flipV, and rot, which there are no plans 
		// to implement
		 
		foreach($node->children("a", TRUE)->children("a", TRUE) as $subNode) {
		    echo "-----> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
	            case 'off':
		            // offset
		            $attributes = $subNode->attributes();
		            $this->x = (float)$attributes->x;
		            $this->y = (float)$attributes->y;
		            break;
    
	            case 'ext':
		            // extent 
		            $attributes = $subNode->attributes();
		            $this->cx = (float)$attributes->x;
		            $this->cy = (float)$attributes->y;
		            break;
            }
		}	
	}
}

?>
