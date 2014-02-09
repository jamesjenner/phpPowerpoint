phpPowerpoint
=============

A php library that can process Microsoft Office PowerPoint (pptx) files. 

Microsoft, Microsoft Office and Powerpoint are either registered trademarks or trademarks of Microsoft Corporation in the United States and/or other countries.

Please note that this library uses name spaces.

A non name space version is available. The non name space is more feature complete, as it was used in conjuntion with Drupal 7.




Reference Information
---------------------

Bullet Points

http://msdn.microsoft.com/en-us/library/documentformat.openxml.drawing.textautonumberschemevalues.aspx


Structure of a PresentationML Document

http://msdn.microsoft.com/en-us/library/gg278335.aspx

Working with Slide Masters

http://msdn.microsoft.com/en-us/library/gg278321.aspx

Working with Slide Layouts:

http://msdn.microsoft.com/en-us/library/gg278311.aspx


DocumentForm at.OpenXml.Presentation Namespace (basically lists all the different types)

http://msdn.microsoft.com/en-us/library/cc884925.aspx


TODO: 
-----

Currently half way through Master.php. Need to implement the following empty methods on the Master class:

- private function processColorMap()
- private function processSlideLayoutIdList()
- private function processTextStyles()

The last two are important, the first one is of a lower priority.
