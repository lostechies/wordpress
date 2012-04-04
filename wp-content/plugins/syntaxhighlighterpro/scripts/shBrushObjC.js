/**
 * SyntaxHighlighter
 * http://alexgorbatchev.com/
 *
 * SyntaxHighlighter is donationware. If you are using it, please donate.
 * http://alexgorbatchev.com/wiki/SyntaxHighlighter:Donate
 *
 * @version
 * 2.1.364 (October 15 2009)
 * 
 * @copyright
 * Copyright (C) 2004-2009 Alex Gorbatchev.
 *
 * @license
 * This file is part of SyntaxHighlighter.
 * 
 * SyntaxHighlighter is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SyntaxHighlighter is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SyntaxHighlighter.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
 */
SyntaxHighlighter.brushes.ObjC = function()
{
	var datatypes =
	'char bool BOOL double float int ' +
	'long short id void';

	var keywords = 
	'IBAction IBOutlet SEL YES NO readwrite readonly nonatomic nil NULL ' +
	'super self copy ' +
	'break case catch class const copy __finally __exception __try ' +
	'const_cast continue private public protected __declspec ' + 
	'default delete deprecated dllexport dllimport do dynamic_cast ' + 
	'else enum explicit extern if for friend goto inline ' + 
	'mutable naked namespace new noinline noreturn nothrow ' + 
	'register reinterpret_cast return selectany ' + 
	'sizeof static static_cast struct switch template this ' + 
	'thread throw true false try typedef typeid typename union ' + 
	'using uuid virtual volatile whcar_t while';


	this.regexList = [

		{ regex: SyntaxHighlighter.regexLib.singleLineCComments,	css: 'comment' },			// one line comments
		{ regex: SyntaxHighlighter.regexLib.multiLineCComments,		css: 'comment' },			// multiline comments
		{ regex: SyntaxHighlighter.regexLib.doubleQuotedString,		css: 'string' },			// strings
		{ regex: SyntaxHighlighter.regexLib.singleQuotedString,		css: 'string' },			// strings
		{ regex: new RegExp('^ *#.*', 'gm'),				css: 'preprocessor' },
		{ regex: new RegExp(this.getKeywords(datatypes), 'gm'),		css: 'datatypes' },
		{ regex: new RegExp(this.getKeywords(keywords), 'gm'),		css: 'keyword' },
		{ regex: new RegExp('\\bNS\\w+\\b', 'g'),			css: 'keyword' },
		{ regex: new RegExp('@\\w+\\b', 'g'),				css: 'keyword' }


		];
		
	this.forHtmlScript(SyntaxHighlighter.regexLib.aspScriptTags);
};

SyntaxHighlighter.brushes.ObjC.prototype	= new SyntaxHighlighter.Highlighter();
SyntaxHighlighter.brushes.ObjC.aliases	= ['obj-c', 'objc'];

