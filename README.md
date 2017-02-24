## PHPAwesome - Completion

### What is PHPAweosme?
PHP Aweosme is a series of VIM plugins to make developing PHP in VIM much easier and quicker, so developers don't have to forsake *all* of the features of PHPStorm if they choose VIM

### What makes PHPAwesome - Completion different to other PHP Omnifunctions?
The main difference is that rather than relying on PHP Reflection to collect shallow information about classes through dockblocks and type-hinting,
PHPAwesome - Completion also seeks to make educated guesses about the types of properties or return types of classes when they aren't otherwise
defined. This should hopefully bring us closer to an actually intelligent solution, as opposed to a very shallow autocompletion.

### How does it work?
This plugin works by indexing the PHP files in the background. To do the indexing, it tokenizes the PHP code, so that it can inspect code that would
cause Reflection to throw a fatal error, as well as make inspections in to the body of methods and functions. The purpose of this is to try and 
take a property, find all of the points where that proeprty is written to and see if we can't make educated guesses about it's types based on that

### How complete is it?
It's not
