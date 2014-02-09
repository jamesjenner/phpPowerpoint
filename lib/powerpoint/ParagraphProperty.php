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
 * ParagraphProperty is a class for representing the properties from a paragraph as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * ParagraphProperty is used by .
 *  
 * Note that there are 9 levels for paragraph properties, only the url for the first one is provided, change the 1 to the number required. 
 *   
 * @see PowerPoint 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm
 * @link http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.defaultparagraphproperties.aspx
 * @link http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.level1paragraphproperties.aspx  	 	 
 */ 
class ParagraphProperty {

    /** standard bullets, this is the default style for a paragraph */
    const BULLETS = 0;
    /** no bullets */
    const NO_BULLETS = 1;
    /** auto numbered bullets */
    const AUTO_NUMBERED_BULLETS = 2;

    /** bullet type of alphabetic lower case with leading ( and trailing ). e.g. (a), (b), (c), ... */
    const ALPHA_LOWER_CHARACTER_PAREN_BOTH = 0;
    /** bullet type of alphabetic upper case with leading ( and a trailing ). e.g. (A), (B), (C), ... */
    const ALPHA_UPPER_CHARACTER_PAREN_BOTH = 1;
    /** bullet type of alphabetic lower case with a trailing ). e.g. a), b), c), ... */
    const ALPHA_LOWER_CHARACTER_PAREN_R = 2;
    /** bullet type of alphabetic upper case with a trailing ). e.g. A), B), C), ... */
    const ALPHA_UPPER_CHARACTER_PAREN_R = 3;
    /** bullet type of alphabetic lower case with trailing fullstop. e.g. a., b., c., ... */
    const ALPHA_LOWER_CHARACTER_PERIOD = 4;
    /** bullet type of alphabetic upper case with trailing fullstop. e.g. A., B., C., ... */
    const ALPHA_UPPER_CHARACTER_PERIOD = 5;
    /** bullet type of numeric with leading ( and trailing ). e.g. (1), (2), (3), ... */
    const ARABIC_PAREN_BOTH = 6;
    /** bullet type of numeric with a trailing ). e.g. 1), 2), 3), ... */
    const ARABIC_PAREN_R = 7;
    /** bullet type of numeric with a trailing fullstop. e.g. 1), 2), 3), ... */
    const ARABIC_PERIOD = 8;
    /** bullet type of numeric. e.g. 1, 2, 3, ... */
    const ARABIC_PLAIN = 9;
    /** bullet type of roman numerals lower case with leading ( and trailing ). e.g. (i), (ii), (iii), ... */
    const ROMAN_LOWER_CHARACTER_PAREN_BOTH = 10;
    /** bullet type of roman numerals upper case with leading ( and trailing ). e.g. (I), (II), (III), ... */
    const ROMAN_UPPER_CHARACTER_PAREN_BOTH = 11;
    /** bullet type of roman numerals lower case with a trailing ). e.g. i), ii), iii), ... */
    const ROMAN_LOWER_CHARACTER_PAREN_R = 12;
    /** bullet type of roman numerals upper case with a trailing ). e.g. I), II), III), ... */
    const ROMAN_UPPER_CHARACTER_PAREN_R = 13;
    /** bullet type of roman numerals lower case with trailing fullstop. e.g. i., ii., iii., ... */
    const ROMAN_LOWER_CHARACTER_PERIOD = 14;
    /** bullet type of roman numerals upper case with trailing fullstop. e.g. I., II., III., ... */
    const ROMAN_UPPER_CHARACTER_PERIOD = 15;
    /** bullet type of a double byte character for a cirlce with number */
    const CIRCLE_NUMBER_DOUBLE_BYTE_PLAIN = 16;
    /** bullet type of wingdings for a cirlce with number with black background */
    const CIRCLE_NUMBER_WINGDINGS_BLACK_PLAIN = 17;
    /** bullet type of wingdings for a cirlce with number with white background */
    const CIRCLE_NUMBER_WINGDINGS_WHITE_PLAIN = 18;
	
    /** bullet type of arabic double byte with trailing fullstop */
	const ARABIC_DOUBLE_BYTE_PERIOD = 19;
    /** bullet type of arabic double byte  */
	const ARABIC_DOUBLE_BYTE_PLAIN = 20;
    /** bullet type of east asian simplified chinese with trailing fullstop  */
	const EAST_ASIAN_SIMPLIFIED_CHINESE_PERIOD = 21;
    /** bullet type of east asian simplified chinese */
	const EAST_ASIAN_SIMPLIFIED_CHINESE_PLAIN = 22;
    /** bullet type of east asian traditional chinese with trailing fullstop  */
	const EAST_ASIAN_TRADITIONAL_CHINESE_PERIOD = 23;
    /** bullet type of east asian traditional chinese */
	const EAST_ASIAN_TRADITIONAL_CHINESE_PLAIN = 24;
    /** bullet type of east asian japanse double byte */
	const EAST_ASIAN_JAPANESE_DOUBLE_BYTE_PERIOD = 25;
    /** bullet type of east asian japanse korean */
	const EAST_ASIAN_JAPANESE_KOREAN_PLAIN = 26;
    /** bullet type of east asian japanse korean with trailing fullstop */
	const EAST_ASIAN_JAPANESE_KOREAN_PERIOD = 27;
    /** bullet type of arabic 1 minus */
	const ARABIC_1_MINUS = 28;
    /** bullet type of arabic 2 minus */
	const ARABIC_2_MINUS = 29;
    /** bullet type of hebrew 1 minus */
	const HEBREW_2_MINUS = 30;
    /** bullet type of thai alphabetic with trailing period */
	const THAI_ALPHA_PERIOD = 31;
    /** bullet type of thai alphabetic with trailing right parenthesis */
	const THAI_ALPHA_PARENTHESIS_RIGHT = 32;
    /** bullet type of thai alphabetic encapsulated with parenthesises */
	const THAI_ALPHA_PARENTHESIS_BOTH = 33;
    /** bullet type of thai numeric with trailing fullstop */
	const THAI_NUMBER_PERIOD = 34;
    /** bullet type of thai numeric with trailing right parnthesis */
	const THAI_NUMBER_PARENTHESIS_RIGHT = 35;
    /** bullet type of thai numeric with encapsulating parenthesises */
	const THAI_NUMBER_PARENTHESIS_BOTH = 36;
    /** bullet type of hindi alphabetic with trailing fullstop */
	const HINDI_ALPHA_PERIOD = 37;
    /** bullet type of hindi numeric with trailing fullstop */
	const HINDI_NUM_PERIOD = 38;
    /** bullet type of hindi numeric with trailing right parnthesis */
	const HINDI_NUMBER_PARENTHESIS_RIGHT = 39;
    /** bullet type of hindi alphanumeric 1 with trailing fullstop */
	const HINDI_ALPHA_1_PERIOD = 40;
	
    /** left, used for justficiation */
    const LEFT = 0;
    /** center, used for justficiation */
    const CENTER = 1;
    /** right, used for justficiation */
    const RIGHT = 2;

	private $node;
	private $parentNode;

    /** the level for the paragraph property */
    public $level;
    /** the style of bullets used, ie NO_BULLETS, AUTO_NUMBERED_BULLETS, etc */
	public $bulletStyle;
    /** the type of bullets used, eg ARABIC_PLAIN, ARABIC_PERIOD, etc */
    public $bulletType;
    /** the alignment of the paragraph */
	public $alignment;
    /** the starting number for the current sequence of bullet points */
    public $bulletStartsAt;

	public function __construct($parentNode, $node = NULL, $level = 0) {
		$this->parentNode = $parentNode;
		$this->node = $node;
		$this->level = $level;
		
		// do we need a default style of bullets? maybe this should be bullets instead
	    $this->bulletStyle = ParagraphProperty::NO_BULLETS;

        if(isset($node)) {
            $this->processParagraphProperty($node);
        }
	}

	/**
	 * processParagraphProperty process the specified paragraph property node
	 * 
	 * @param $node the node that represents a paragraph property 
	 * 
	 * @see 
	 */	     
	private function processParagraphProperty($node) {
        $this->processParargraphPropertyAttributes($node);
	
		foreach($node->children("a", TRUE) as $subNode) {
		    echo "-------> " . $subNode->getName() . "<br>";

			switch($subNode->getName()) {
	            case 'defRPr':
		            // default run properties
		            $this->processDefaultRunProperties($subNode);
		            break;

	            case 'buAutoNum':
		            $this->bulletStyle = ParagraphProperty::AUTO_NUMBERED_BULLETS;
                    $this->determineBullets($subNode);
					// paragraph 
		            break;
		            
	            case 'buBlip':
		            // picture bullet 
		            // @todo: not implemented
		            break;
		            
	            case 'buChar':
		            // character bullet
		            // @todo: not implemented
		            break;
		            
	            case 'buClr':
		            // bullet color specified
		            // @todo: not implemented
		            break;
		            
	            case 'buClrTx':
		            // bullet follow text
					// @todo: not implemented 
		            break;
		            
	            case 'buFont':
		            // bullet font specified
		            // @todo: not implemented
		            break;
		            
	            case 'buFontTx':
		            // bullet font follow text?!?!
		            // @todo: not implemented
		            break;
		            
	            case 'buNone':
                    echo "no bullets <br>";
		            $this->bulletStyle = ParagraphProperty::NO_BULLETS;
		            break;
		            
	            case 'buSzPct':
		            // bullet size percentage
		            // @todo: not implemented
		            break;
		            
	            case 'buSzPts':
		            // bullet size points
		            // @todo: not implemented
		            break;
		            
	            case 'buSzTx':
		            // bullet size follows text
		            // @todo: not implemented
		            break;
		            
	            case 'defRPr':
		            // paragraph default run text properties
		            break;
		            
	            case 'extLst':
		            // extension list
		            // @todo: not implemented
		            break;
		            
	            case 'lnSpc':
		            // line spacing
		            // @todo: not implemented
		            break;
		            
	            case 'spcAft':
		            // space after
		            // @todo: not implemented
		            break;
		            
	            case 'spcBef':
		            // space before
		            // @todo: not implemented
		            break;
		            
	            case 'tabLst':
		            // tab list
		            // @todo: not implemented
		            break;
            }
        }
	}
	
	/**
	 * processParargraphPropertyAttributes process the attributes for the paragraph property node
	 *	 
	 * @param $node the node for the paragraph property	 
	 */	 	
	private function processParargraphPropertyAttributes($node) {
        $attributes = $node->attributes();

	    if((string)$attributes->algn === 'r') {
	        $this->alignment = ParagraphProperty::RIGHT;
	    } else if((string)$attributes->algn === 'ctr') {
	        $this->alignment = ParagraphProperty::CENTER;
	    }
	    
	    if(isset($attributes->lvl)) {
	        // if level is specified then it overrides the level 
	        $this->level = (int)$attributes->lvl; 
		}
	}
	
    /**
     * processBodyProperties process the body properties node
     * 
     * @param $node the node that represents a body property
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.bodyproperties.aspx
     */	     
	private function processDefaultRunProperties($node) {
        $attributes = $node->attributes();
	}

	/**
	 * process the specified node to determine the bullet style for the paragraph   
	 *
	 * @todo change bulletStartsAt to represent the actual character when character based, currently it uses numeric, where 1 = a, 2 = b, etc.
	 * @param node the node to be processed	 
	 */ 
	private function determineBullets($textNode) {
	    $this->bulletStartsAt = $this->getBulletStartsAt($textNode);
	    $this->bulletType = $this->getBulletType($textNode);
	}
	
	/**
	 * getBulletStartsAt get the start number for a bullet based on the specified node
	 *  
	 * for non numeric bullets, the number is converted to character, with the first character of the character set equal to 1.
	 * 	 	  
	 * @param $node the node that contains the bullet attribute
	 * 
	 * @return string the number that the bullet starts at 	 	 	 	 
	 */	 	
	private function getBulletStartsAt($node) {
		$attributes = $node->attributes();
	    
	    // test if start at is specified, string is evaluated as false if empty by php
	    if(trim($attributes->startAt)) {
	        return (string)$attributes->startAt;
		} else {
		    return "1"; 
		}
	}
	
	/**
	 * getBulletType get the type of bullet 
	 *  
	 * for non numeric bullets, the number is converted to character, with the first character of the character set equal to 1.
	 * 	 	  
	 * @param $node the node that contains the bullet attribute
	 * @param $defaultType the default type of bullet. this defaults to ParagraphProperty::ARABIC_PLAIN
	 * 
	 * @return string the the type of bullet as specified by the parsed node 	 	 	 	 
	 */	 	
	private function getBulletType($node, $defaultType = ParagraphProperty::ARABIC_PLAIN) {
		$attributes = $node->attributes();
		
	    $bulletType = $defaultType;
	    
	    // process the type of bullet, refer to const definitions for explination of each type
	    switch($attributes->type) {
			case "alphaLcParenBoth": 
			    $bulletType = ParagraphProperty::ALPHA_LOWER_CHARACTER_PAREN_BOTH;
			    break;
			case "alphaUcParenBoth":
			    $bulletType = ParagraphProperty::ALPHA_UPPER_CHARACTER_PAREN_BOTH;
			    break;
			case "alphaLcParenR":
			    $bulletType = ParagraphProperty::ALPHA_LOWER_CHARACTER_PAREN_R;
			    break;
			case "alphaUcParenR":
			    $bulletType = ParagraphProperty::ALPHA_UPPER_CHARACTER_PAREN_R;
			    break;
			case "alphaLcPeriod":
			    $bulletType = ParagraphProperty::ALPHA_LOWER_CHARACTER_PERIOD;
			    break;
			case "alphaUcPeriod":
			    $bulletType = ParagraphProperty::ALPHA_UPPER_CHARACTER_PERIOD;
			    break;
			case "arabicParenBoth":
			    $bulletType = ParagraphProperty::ARABIC_PAREN_BOTH;
			    break;
			case "arabicParenR":
			    $bulletType = ParagraphProperty::ARABIC_PAREN_R;
			    break;
			case "arabicPeriod":
			    $bulletType = ParagraphProperty::ARABIC_PERIOD;
			    break;
			case "arabicPlain":
			    $bulletType = ParagraphProperty::ARABIC_PLAIN;
			    break;
			case "romanLcParenBoth":
			    $bulletType = ParagraphProperty::ROMAN_LOWER_CHARACTER_PAREN_BOTH;
			    break;
			case "romanUcParenBoth":
			    $bulletType = ParagraphProperty::ROMAN_UPPER_CHARACTER_PAREN_BOTH;
			    break;
			case "romanLcParenR":
			    $bulletType = ParagraphProperty::ROMAN_LOWER_CHARACTER_PAREN_R;
			    break;
			case "romanUcParenR":
			    $bulletType = ParagraphProperty::ROMAN_UPPER_CHARACTER_PAREN_R;
			    break;
			case "romanLcPeriod":
			    $bulletType = ParagraphProperty::ROMAN_LOWER_CHARACTER_PERIOD;
			    break;
			case "romanUcPeriod":
			    $bulletType = ParagraphProperty::ROMAN_UPPER_CHARACTER_PERIOD;
			    break;
			case "circleNumDbPlain":
			    $bulletType = ParagraphProperty::CIRCLE_NUMBER_DOUBLE_BYTE_PLAIN;
			    break;
			case "circleNumWdBlackPlain":
			    $bulletType = ParagraphProperty::CIRCLE_NUMBER_WINGDINGS_BLACK_PLAIN;
			    break;
			case "circleNumWdWhitePlain":
			    $bulletType = ParagraphProperty::CIRCLE_NUMBER_WINGDINGS_WHITE_PLAIN;
			    break;
			case "arabicDbPeriod":
			    $bulletType = ParagraphProperty::ARABIC_DOUBLE_BYTE_PERIOD; 
			    break;
			case "arabicDbPlain":
			    $bulletType = ParagraphProperty::ARABIC_DOUBLE_BYTE_PLAIN; 
			    break;
			case "ea1ChsPeriod":
			    $bulletType = ParagraphProperty::EAST_ASIAN_SIMPLIFIED_CHINESE_PERIOD; 
			    break;
			case "ea1ChsPlain":
			    $bulletType = ParagraphProperty::EAST_ASIAN_SIMPLIFIED_CHINESE_PLAIN; 
			    break;
			case "ea1ChtPeriod":
			    $bulletType = ParagraphProperty::EAST_ASIAN_TRADITIONAL_CHINESE_PERIOD; 
			    break;
			case "ea1ChtPlain":
			    $bulletType = ParagraphProperty::EAST_ASIAN_TRADITIONAL_CHINESE_PLAIN; 
			    break;
			case "ea1JpnChsDbPeriod":
			    $bulletType = ParagraphProperty::EAST_ASIAN_JAPANESE_DOUBLE_BYTE_PERIOD; 
			    break;
			case "ea1JpnKorPlain":
			    $bulletType = ParagraphProperty::EAST_ASIAN_JAPANESE_KOREAN_PLAIN; 
			    break;
			case "ea1JpnKorPeriod":
			    $bulletType = ParagraphProperty::EAST_ASIAN_JAPANESE_KOREAN_PERIOD;
			    break;
			case "arabic1Minus":
			    $bulletType = ParagraphProperty::ARABIC_1_MINUS; 
			    break;
			case "arabic2Minus":
			    $bulletType = ParagraphProperty::ARABIC_2_MINUS; 
			    break;
			case "hebrew2Minus":
			    $bulletType = ParagraphProperty::HEBREW_2_MINUS; 
			    break;
			case "thaiAlphaPeriod":
			    $bulletType = ParagraphProperty::THAI_ALPHA_PERIOD; 
			    break;
			case "thaiAlphaParenR":
			    $bulletType = ParagraphProperty::THAI_ALPHA_PARENTHESIS_RIGHT; 
			    break;
			case "thaiAlphaParenBoth":
			    $bulletType = ParagraphProperty::THAI_ALPHA_PARENTHESIS_BOTH; 
			    break;
			case "thaiNumPeriod":
			    $bulletType = ParagraphProperty::THAI_NUMBER_PERIOD; 
			    break;
			case "thaiNumParenR":
			    $bulletType = ParagraphProperty::THAI_NUMBER_PARENTHESIS_RIGHT; 
			    break;
			case "thaiNumParenBoth":
			    $bulletType = ParagraphProperty::THAI_NUMBER_PARENTHESIS_BOTH; 
			    break;
			case "hindiAlphaPeriod":
			    $bulletType = ParagraphProperty::HINDI_ALPHA_PERIOD; 
			    break;
			case "hindiNumPeriod":
			    $bulletType = ParagraphProperty::HINDI_NUM_PERIOD; 
			    break;
			case "hindiNumParenR":
			    $bulletType = ParagraphProperty::HINDI_NUMBER_PARENTHESIS_RIGHT; 
			    break;
			case "hindiAlpha1Period":
			    $bulletType = ParagraphProperty::HINDI_ALPHA_1_PERIOD; 
			    break;
		}
		
		return $bulletType;
	}

    /** 
     * getBulletTypeClassDef get the class definition for the bullet type
     * 
     * the class is based off the property.css file and is used to 
     * define bullets in css as html is too restrictive in what can and
     * cannot be done.
     * 	 	 	 	      
     * $return the css class for the bullet type
     */	        
	public function getBulletTypeClassDef() {
	
		switch($this->bulletType) {
            default:
         	    $markup = 'list_style_default';

		    case ParagraphProperty::ALPHA_LOWER_CHARACTER_PAREN_BOTH:
		        $markup = 'list_style_alpha_lower_char_paren_both';
		        break;
		    case ParagraphProperty::ALPHA_UPPER_CHARACTER_PAREN_BOTH:
		        $markup = 'list_style_alpha_upper_char_paren_both';
		        break;
		    case ParagraphProperty::ALPHA_LOWER_CHARACTER_PAREN_R:
		        $markup = 'list_style_alpha_lower_char_paren_r';
		        break;
		    case ParagraphProperty::ALPHA_UPPER_CHARACTER_PAREN_R:
		        $markup = 'list_style_alpha_upper_char_paren_r';
		        break;
		    case ParagraphProperty::ALPHA_LOWER_CHARACTER_PERIOD:
		        $markup = 'list_style_alpha_lower_char_period';
		        break;
		    case ParagraphProperty::ALPHA_UPPER_CHARACTER_PERIOD:
		        $markup = 'list_style_alpha_upper_char_period';
		        break;
		    case ParagraphProperty::ARABIC_PAREN_BOTH:
		        $markup = 'list_style_arabic_paren_both';
		        break;
		    case ParagraphProperty::ARABIC_PAREN_R:
		        $markup = 'list_style_arabic_paren_r';
		        break;
		    case ParagraphProperty::ARABIC_PERIOD:
		        $markup = 'list_style_arabic_period';
		        break;
		    case ParagraphProperty::ARABIC_PLAIN:
		        $markup = 'list_style_arabic_plain';
		        break;
		    case ParagraphProperty::ROMAN_LOWER_CHARACTER_PAREN_BOTH:
		        $markup = 'list_style_roman_lower_char_paren_both';
		        break;
		    case ParagraphProperty::ROMAN_UPPER_CHARACTER_PAREN_BOTH:
		        $markup = 'list_style_roman_upper_char_paren_both';
		        break;
		    case ParagraphProperty::ROMAN_LOWER_CHARACTER_PAREN_R:
		        $markup = 'list_style_romon_lower_char_paren_r';
		        break;
		    case ParagraphProperty::ROMAN_UPPER_CHARACTER_PAREN_R:
		        $markup = 'list_style_roman_upper_char_paren_r';
		        break;
		    case ParagraphProperty::ROMAN_LOWER_CHARACTER_PERIOD:
		        $markup = 'list_style_roman_lower_char_period';
		        break;
		    case ParagraphProperty::ROMAN_UPPER_CHARACTER_PERIOD:
		        $markup = 'list_style_roman_upper_char_period';
		        break;
		    case ParagraphProperty::CIRCLE_NUMBER_DOUBLE_BYTE_PLAIN:
		        $markup = 'list_style_circle_num_double_byte_plain';
		        break;
		    case ParagraphProperty::CIRCLE_NUMBER_WINGDINGS_BLACK_PLAIN:
		        $markup = 'list_style_circle_num_wingdings_black_plain';
		        break;
		    case ParagraphProperty::CIRCLE_NUMBER_WINGDINGS_WHITE_PLAIN:
		        $markup = 'list_style_circle_num_wingdings_white_plain';
		        break;
			case ParagraphProperty::ARABIC_DOUBLE_BYTE_PERIOD:
		        $markup = 'list_style_arabic_double_byte_period';
		        break;
			case ParagraphProperty::ARABIC_DOUBLE_BYTE_PLAIN:
		        $markup = 'list_style_arabic_double_byte_plain';
		        break;
			case ParagraphProperty::EAST_ASIAN_SIMPLIFIED_CHINESE_PERIOD:
		        $markup = 'list_style_east_asian_simplified_chinese_period';
		        break;
			case ParagraphProperty::EAST_ASIAN_SIMPLIFIED_CHINESE_PLAIN:
		        $markup = 'list_style_east_asian_simplified_chinese_plain';
		        break;
			case ParagraphProperty::EAST_ASIAN_TRADITIONAL_CHINESE_PERIOD:
		        $markup = 'list_style_east_asian_traditional_chinese_period';
		        break;
			case ParagraphProperty::EAST_ASIAN_TRADITIONAL_CHINESE_PLAIN:
		        $markup = 'list_style_east_asian_traditional_chinese_plain';
		        break;
			case ParagraphProperty::EAST_ASIAN_JAPANESE_DOUBLE_BYTE_PERIOD:
		        $markup = 'list_style_east_asian_japanese_double_byte_period';
		        break;
			case ParagraphProperty::EAST_ASIAN_JAPANESE_KOREAN_PLAIN:
		        $markup = 'list_style_east_asian_japanese_korean_plain';
		        break;
			case ParagraphProperty::EAST_ASIAN_JAPANESE_KOREAN_PERIOD:
		        $markup = 'list_style_east_asian_japanese_korean_period';
		        break;
			case ParagraphProperty::ARABIC_1_MINUS:
		        $markup = 'list_style_arabic_1_minus';
		        break;
			case ParagraphProperty::ARABIC_2_MINUS:
		        $markup = 'list_style_arabic_2_minus';
		        break;
			case ParagraphProperty::HEBREW_2_MINUS:
		        $markup = 'list_style_hebrew_2_minus';
		        break;
			case ParagraphProperty::THAI_ALPHA_PERIOD:
		        $markup = 'list_style_thai_alpha_period';
		        break;
			case ParagraphProperty::THAI_ALPHA_PARENTHESIS_RIGHT:
		        $markup = 'list_style_thai_alpha_paren_r';
		        break;
			case ParagraphProperty::THAI_ALPHA_PARENTHESIS_BOTH:
		        $markup = 'list_style_thai_alpha_paren_both';
		        break;
			case ParagraphProperty::THAI_NUMBER_PERIOD:
		        $markup = 'list_style_thai_num_period';
		        break;
			case ParagraphProperty::THAI_NUMBER_PARENTHESIS_RIGHT:
		        $markup = 'list_style_thai_num_paren_r';
		        break;
			case ParagraphProperty::THAI_NUMBER_PARENTHESIS_BOTH:
		        $markup = 'list_style_thai_num_paren_both';
		        break;
			case ParagraphProperty::HINDI_ALPHA_PERIOD:
		        $markup = 'list_style_hindi_alpha_period';
		        break;
			case ParagraphProperty::HINDI_NUM_PERIOD:
		        $markup = 'list_style_hindi_num_period';
		        break;
			case ParagraphProperty::HINDI_NUMBER_PARENTHESIS_RIGHT:
		        $markup = 'list_style_hindi_num_paren_r';
		        break;
			case ParagraphProperty::HINDI_ALPHA_1_PERIOD:
		        $markup = 'list_style_hindi_alpha_1_period';
		        break;
		}

	    return $markup;
	}   
}

?>
