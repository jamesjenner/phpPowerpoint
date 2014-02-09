<?php

namespace phpoffice\powerpoint;

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

function __autoload($class) {
	// convert namespace to full file path
	$class = str_replace('\\', '/', $class) . '.php';
	require_once($class);
}

/** location of the presentation relationship file */
const PRESENTATION_RELATIONSHIPS = '#ppt/_rels/presentation.xml.rels';
/** location of presentation xml file */
const PRESENTATION = '#ppt/presentation.xml';
// const FILE_SCHEME = 'zip://';

use phpoffice\OfficeDocument;
use phpoffice\Relationship;


/**
 * Powerpoint is a class for representing a powerpoint presentation as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * @see OfficeDocument 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm	 	 
 */ 
class Powerpoint extends OfficeDocument {
	private $relationships;
	private $xml;
	private $slides;
	
	public function getNumberOfSlides() {
		return count($this->slides);
	}
	
	public function getSlide($number) {
		return $this->slides[$number];
	}

	/**
	 * buildAll processes the various files to generate the powerpoint presentation for the current instance
	 * 
	 * @see Powerpoint	 	 
	 */ 
	public function buildAll() {
		$this->buildRelationships();
		$this->buildMasters();
		$this->buildPresentation();
	}
	
	/**
	 * getHTML retreives from all components of the power point instance producing a html markup representation of the presentation
	 * 	 
	 * @param string $pageTag the tag to insert to deliminate pages for the presentation, default is "div" 
	 * @param string $tagLeftDelim the deliminator for the left of the page tag, default is "<"
	 * @param string $tagRightDelim the deliminator for the right of the page tag, default is "<"
	 * 	 
	 * @return string the html markup for the powerpoint presentation 	 	  
	 */
	public function getHTML($pageTag = "div", $tagLeftDelim = "<", $tagRightDelim = ">") {
	    $markup = '';
	    
	    if($this->getnumberOfSlides() > 0) {
	        foreach($this->slides as $slide) {
                $markup .= $tagLeftDelim . $pageTag . $tagRightDelim . $slide->getHTML() . $tagLeftDelim . "/" . $pageTag . $tagRightDelim;
			}
		}
		
		return $markup;
	}	 	
	
	/**
	 * getfile retreive the file for the Powerpoint instance
	 * 
	 * @see Powerpoint	 	 
	 */ 
	public function getfile() {
		return $this->file;
	}
	
	/**
	 * buildRelationships build the relationships for the presentation 
	 * 
	 * @see Powerpoint	 	 
	 */ 
	private function buildRelationships() {
		$xml = simplexml_load_file(Slide::FILE_SCHEME . $this->file . PRESENTATION_RELATIONSHIPS);

		if($xml === FALSE) {
			throw new Exception("Error opening file: " . Slide::FILE_SCHEME . $this->file . PRESENTATION_RELATIONSHIPS);
		}
		
		foreach ($xml->Relationship as $rel) {
			$relationship = new Relationship();
		
			$relationship->id = (string)$rel['Id'];
			$relationship->type = (string)$rel['Type'];
			$relationship->target = (string)$rel['Target'];

			$this->relationships[$relationship->id] = $relationship;
		}
	}


	
	/**
	 * buildMasters build the masters for the presentation 
	 * 
	 * @see Powerpoint	 	 
	 */ 
	private function buildMasters() {
	
	}
	
	/**
	 * buildSlides build the slides for the presentation 
	 * 
	 * @see Powerpoint	 	 
	 */ 
	private function buildPresentation() {
		$xml = simplexml_load_file(Slide::FILE_SCHEME . $this->file . PRESENTATION);
		
		if($xml === FALSE) {
			throw new Exception("Error opening file: " . Slide::FILE_SCHEME . $this->file . PRESENTATION);
		}

        // iterate through the presentation structure 
        $entries = $xml->children('p', TRUE);
        foreach ($entries as $entry) {
            switch($entry->getName()) {
                 case 'sldMasterIdLst':
                      // slide master id list
                      $this->processMasterIdList($entry);
                 	  break;
                 case 'sldIdLst':
                      // slide id list
                      // processSlideIdList($entry);
                      $this->processSlideIdList($entry);
                 	  break;
                 case 'sldSz':
                      // ???
                 	  break;
                 case 'notesSz':
                      // ???
                 	  break;
                 case 'defaultTextStyle':
                      // default text styles
                      // processDefaultTextStyles();  
					  // this will most prob have things like font size, hanging indent, etc.
					  // may not be required as not editing slides, just extracting 
                 	  break;
         	     default:
         	          // unknown type, so ignore
			}
		}
/*
        // build slides
		$sldIdLst = $xml->children('p', TRUE)->sldIdLst->children('p', TRUE)->sldId;
		$this->slides = array();
		
		foreach ($sldIdLst as $sldId) {
			$attributes = $sldId->attributes();
			$attributes2 = $sldId->attributes("r", 1);
			
			$id = (string) $attributes->id;
			$rid = (string) $attributes2->id;
			
			$slideId = (string) $attributes->id;
			$slideFilename = $this->relationships[(string) $attributes2->id]->target;

			$slide = new Slide($this, $slideId, $slideFilename);
			
			$slide->build();
			
			$this->slides[] = $slide;
		}
		*/
		foreach($this->masters as $master) {
		    $master->build();
		}
		foreach($this->slides as $slide) {
		    $slide->build();
		}
	}

    private function processSlideIdList($slideIdsNodes) {
		foreach($slideIdsNodes->children("p", TRUE) as $slideIdNode) {
	        if($slideIdNode->getName() === 'sldId') {
                $attributes = $slideIdNode->attributes();
                $attributes2 = $slideIdNode->attributes("r", 1);

			    $slideId = (string) $attributes->id;
			    $slideFilename = $this->relationships[(string) $attributes2->id]->target;
			    echo "slide - id: " . $slideId . " filename: " . $slideFilename . "<br>";
			    $this->slides[] = new Slide($this, $slideId, $slideFilename);
			}
		}
	}
	
	private function processMasterIdList($masterIdsNodes) {
		foreach($masterIdsNodes->children("p", TRUE) as $masterIdNode) {
	        if($masterIdNode->getName() === 'sldMasterId') {
                $attributes = $masterIdNode->attributes();
                $attributes2 = $masterIdNode->attributes("r", 1);

			    $masterId = (string) $attributes->id;
			    $masterFilename = $this->relationships[(string) $attributes2->id]->target;
			    $this->masters[] = new Master($this, $masterId, $masterFilename);
			    echo "master - id: " . $masterId . " rid: " . (string) $attributes2->id . " filename: " . $masterFilename . "<br>"; 
			}
		}
	}
	
	/**
	 * getTarget get the target from the relatiomnships based on the specified id 
	 * 
	 * @param id the id to lookup to find the correct relationships
	 * @return target the target that is mapped to the specified id
	 * 	  	 
	 * @see buildRelationships	 	 
	 */ 
	protected function getTarget($id) {
		return $relationships[$id]->target;
	}
}

?>
