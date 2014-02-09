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
 * TextBody is a class for representing a text body as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * TextBody is used by .
 *  
 * @todo implement fully the specification for shape, if required 
 *  
 * @see PowerPoint 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm
 * @link http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.textbody.aspx 	 	 
 */ 
class TextBody {

	private $node;
	private $parentNode;

    /** the default paragraph properties */
    public $defaultParagraphProperties;
    
    /** defines the paragraph properties per level, where the array is based on the level */
    public $paragraphLevelProperties;

    // todo: add constants for the text based properties of this class 
	
    /** Specifies the anchoring position of the txBody within the shape */
    public $anchor;
    /** Specifies the centering of the text box. The way it works fundamentally is to determine the smallest possible "bounds box" for the text and then to center that "bounds box" accordingly. This is different than paragraph alignment, which aligns the text within the "bounds box" for the text. This flag is compatible with all of the different kinds of anchoring. */
    public $anchorCtr;
    /** Specifies the bottom inset of the bounding rectangle. Insets are used just as internal margins for text boxes within shapes. */
    public $bottomInset; 
    /** Specifies that the line spacing for this text body is decided in a simplistic manner using the font scene. */
    public $compatibleLineSpacing; 
    /** Forces the text to be rendered anti-aliased regardless of the font size. Certain fonts can appear grainy around their edges unless they are anti-aliased. Therefore this attribute allows for the specifying of which bodies of text should always be anti-aliased and which ones should not. */
    public $forceAntiAlias; 
    /** Specifies that text within this textbox is converted text from a WordArt object. This is more of a backwards compatibility attribute that is useful to the application from a tracking perspective. WordArt was the former way to apply text effects and therefore this attribute is useful in document conversion scenarios. */
    public $fromWordArt;
    /** Determines whether the text can flow out of the bounding box horizontally. This is used to determine what happens in the event that the text within a shape is too large for the bounding box it is contained within. */
    public $textHorizontalOverflow;
    /** Specifies the left inset of the bounding rectangle. Insets are used just as internal margins for text boxes within shapes. */
    public $leftInset;
    /** Specifies the number of columns of text in the bounding rectangle. When applied to a text run this property takes the width of the bounding box for the text and divides it by the number of columns specified. These columns are then treated as overflow containers in that when the previous column has been filled with text the next column acts as the repository for additional text. When all columns have been filled and text still remains then the overflow properties set for this text body are used and the text is reflowed to make room for additional text. */
    public $numberOfColumns;
    /** Specifies the right inset of the bounding rectangle. Insets are used just as internal margins for text boxes within shapes. */
    public $rightInset;
    /** Specifies the rotation that is being applied to the text within the bounding box. If it not specified, the rotation of the accompanying shape is used. If it is specified, then this is applied independently from the shape. That is the shape can have a rotation applied in addition to the text itself having a rotation applied to it. */
    public $rotation;
    /** Specifies whether columns are used in a right-to-left or left-to-right order. The usage of this attribute only sets the column order that is used to determine which column overflow text should go to next. */
    public $columnsRightToLeft;
    /** Specifies the space between text columns in the text area. This should only apply when there is more than 1 column present. */
    public $spaceBetweenColumns;
    /** Specifies whether the before and after paragraph spacing defined by the user is to be respected. While the spacing between paragraphs is helpful, it is additionally useful to be able to set a flag as to whether this spacing is to be followed at the edges of the text body, in other words the first and last paragraphs in the text body. More precisely since this is a text body level property it should only effect the before paragraph spacing of the first paragraph and the after paragraph spacing of the last paragraph for a given text body. */
    public $paragraphSpacing;
    /** Specifies the top inset of the bounding rectangle. Insets are used just as internal margins for text boxes within shapes. */
    public $topInset;
    /** Specifies whether text should remain upright, regardless of the transform applied to it and the accompanying shape transform. */
    public $textUpright;
    /** Determines if the text within the given text body should be displayed vertically. */
    public $verticalText;
    /** Determines whether the text can flow out of the bounding box vertically. This is used to determine what happens in the event that the text within a shape is too large for the bounding box it is contained within. */
    public $verticalOverflow;
    /** Specifies the wrapping options to be used for this text body. */
    public $textWrappingType;

	public function __construct($parentNode, $node) {
		$this->parentNode = $parentNode;
		$this->node = $node;

        $this->anchor = 't';
        $this->anchorCtr = 0; // flase
        $this->bottomInset = 45720; 
        $this->compatibleLineSpacing = 0; 
        $this->forceAntiAlias = 0; // false 
        $this->fromWordArt = 0; // false
        $this->textHorizontalOverflow = 'implied';
        $this->leftInset = 91440;
        $this->numberOfColumns = 1;
        $this->rightInset = 91440;
        $this->rotation = 0;
        $this->columnsRightToLeft = 0; // false
        $this->spaceBetweenColumns = 0;
        $this->paragraphSpacing = 0; // false
        $this->topInset = 45720;
        $this->textUpright = 0; // false
        $this->verticalText = 'horz';
        $this->verticalOverflow = 'overflow';
        $this->textWrappingType = 'square';
		
		$this->processTextBody($node);
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
	 * processTextBody process the specified text body node
	 * 
	 * @param $node the node that represents a text body
	 * 
	 * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.textbody.aspx
	 */	     
	private function processTextBody($node) {
		foreach($node->children("a", TRUE) as $subNode) {
		    echo "-----> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
	            case 'bodyPr':
		            // body properties 
		            $this->processBodyProperties($subNode);
		            break;

	            case 'lstStyle':
		            // list style 
		            $this->processListStyles($subNode);
		            break;
    
	            case 'p':
		            // paragraph 
	                $this->paragraphs[] = new Paragraph($subNode);
		            break;
            }
        }
	}
	
    /**
     * processBodyProperties process the body properties node
     * 
     * @param $node the node that represents a body property
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.bodyproperties.aspx
     */	     
	private function processBodyProperties($node) {
        $attributes = $node->attributes();

        $this->anchor = (string)$attributes->anchor;
        $this->anchorCtr = (string)$attributes->anchorCtr;
        $this->bottomInset = (string)$attributes->bIns; 
        $this->compatibleLineSpacing = (string)$attributes->compatLnSpc; 
        $this->forceAntiAlias = (string)$attributes->forceAA; 
        $this->fromWordArt = (string)$attributes->fromWordArt;
        $this->textHorizontalOverflow = (string)$attributes->horzOverflow;
        $this->leftInset = (string)$attributes->lIns;
        $this->numberOfColumns = (string)$attributes->numCol;
        $this->rightInset = (string)$attributes->rIns;
        $this->rotation = (string)$attributes->rot;
        $this->columnsRightToLeft = (string)$attributes->rtlCol;
        $this->spaceBetweenColumns = (string)$attributes->spcCol;
        $this->paragraphSpacing = (string)$attributes->spcFirstLastPara;
        $this->topInset = (string)$attributes->tIns;
        $this->textUpright = (string)$attributes->upright;
        $this->verticalText = (string)$attributes->vert;
        $this->verticalOverflow = (string)$attributes->vertOverflow;
        $this->textWrappingType = (string)$attributes->wrap;
	}

	/**
	 * processListStyles process the specified list style node
	 *
	 * @param $node the node that represents a list style
	 * 
	 * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.liststyle.aspx
	 */	     
	private function processListStyles($node) {
		foreach($node->children("a", TRUE) as $subNode) {
		    echo "------> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
	            case 'defPPr':
		            // default paragraph properties
		            $this->defaultParagraphProperties = new ParagraphProperty($this, $node, $level);
		            break;

	            case 'lvl1pPr':
		            // level 1 paragraph property
					$this->processParagraphLevelProperties(1, $subNode);
		            break;
    
	            case 'lvl2pPr':
		            // level 2 paragraph property
					$this->processParagraphLevelProperties(2, $subNode); 
		            break;
    
	            case 'lvl3pPr':
		            // level 3 paragraph property
					$this->processParagraphLevelProperties(3, $subNode); 
		            break;
    
	            case 'lvl4pPr':
		            // level 4 paragraph property
					$this->processParagraphLevelProperties(4, $subNode); 
		            break;
    
	            case 'lvl5pPr':
		            // level 5 paragraph property
					$this->processParagraphLevelProperties(5, $subNode); 
		            break;
    
	            case 'lvl6pPr':
		            // level 6 paragraph property
					$this->processParagraphLevelProperties(6, $subNode); 
		            break;
    
	            case 'lvl7pPr':
		            // level 7 paragraph property
					$this->processParagraphLevelProperties(7, $subNode); 
		            break;
    
	            case 'lvl8pPr':
		            // level 8 paragraph property
					$this->processParagraphLevelProperties(8, $subNode); 
		            break;
    
	            case 'lvl9pPr':
		            // level 9 paragraph property
					$this->processParagraphLevelProperties(9, $subNode); 
		            break;
		            
	            case 'extLst':
		            // extension list
					// @todo: not implemented 
		            break;
            }
        }
	}
	
	private function processParagraphLevelProperties($level, $node) {
	    $this->paragraphLevelProperties[$level] = new ParagraphProperty($this, $node, $level);
	}
	

}

?>
