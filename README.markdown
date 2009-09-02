# CKEditor - Converts Textareas to a CKEditor Rich Text Box

* **Author**: [George Ornbo][]
* **Source Code**: [Github][]

## Compatibility

* ExpressionEngine Version 1.6.x
* Requires the [jQuery for the Control Panel extension](http://expressionengine.com/downloads/details/jquery_for_the_control_panel/).

## License

CKEditor is free for personal and commercial use. 

If you use it commercially use a donation of $5 is suggested. You can send [donations here](http://pledgie.com/campaigns/5948). 

CKEditor is licensed under a [Open Source Initiative - BSD License][] license.

## Installation

Download CKEditor from [the CKEditor website](http://ckeditor.com/). Extract the zip file and place the ckeditor folder in the root of your site. 

The file ext.ckeditor.php must be placed in the /system/extensions/ folder and the lang.ckeditor.php file must be placed in the /system/language/english/ folder of your [ExpressionEngine][] installation.

Log into your control panel and go to CP Home › Admin › Utilities › Extensions Manager. Activate the extension. You may set preferences here and set CKEditor configuration. 

Refer to [the documentation](http://docs.fckeditor.net/CKEditor_3.x/Developers_Guide) for more information on configuration options. 

## Name

CKEditor

## Synopsis

Converts textareas to a CKEditor Rich Text Box

## Description

CKEditor is an update to the extension written by Jit and published [here](http://expressionengine.com/forums/viewthread/31467/).

It converts textareas into CKEditor rich text boxes.

## Configuration options ##

### URL of CKEditor Script ###

This is the path to the CKEditor Script. If you put your /ckeditor folder in a non-standard location set this here. Otherwise the extension should detect this for you. 

### CKEditor Configuration ###

This provides site authors with the ability to add configuration options to CKEditor. Refer to [the documentation](http://docs.fckeditor.net/CKEditor_3.x/Developers_Guide) for more information on configuration options

A simple example would be to set a Basic toolbar like this:

	CKEDITOR.replace(name,
    {
        toolbar : 'Basic'
    });

### When CKEditor loads ###

This sets when an CKEditor box is loaded. 

* On single click - the editor loads when there is a single click in a textarea
* On double click - the editor loads when there is a double click in a textarea

	
[George Ornbo]: http://shapeshed.com/
[Github]: http://github.com/shapeshed/ckeditor.ee_addon/
[ExpressionEngine]:http://www.expressionengine.com/index.php?affiliate=shapeshed
[Open Source Initiative - BSD License]: http://opensource.org/licenses/bsd-license.php