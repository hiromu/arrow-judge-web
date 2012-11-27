editAreaLoader.load_syntax["cl"] = {
    'DISPLAY_NAME' : 'Common Lisp'
    ,'COMMENT_SINGLE' : [';']
    ,'COMMENT_MULTI' : {'#|' : '|#'}
    ,'QUOTEMARKS' : ['"']
    ,'KEYWORD_CASE_SENSITIVE' : false
    ,'KEYWORDS' : {
	'special-operators' : [
	    'block', 'let*', 'return-from', 'catch', 'load-time-value', 'setq', 'eval-when', 'locally',
  	    'symbol-macrolet', 'flet', 'macrolet', 'tagbody', 'function', 'multiple-value-call',
	    'the', 'go', 'multiple-value-prog1', 'throw', 'if', 'progn', 'unwind-protect', 'labels',
	    'progv', 'let', 'quote'
	]
    }
    ,'OPERATORS' :[
    ]
    ,'DELIMITERS' :[	// Array: the block code delimiters to highlight
	'(', ')'
    ]
    ,'STYLES' : {	// Array: an array of array, containing all style to apply for categories defined before.
	// Better to define color style only. 
	'COMMENTS': 'color: #d46633;'
	,'QUOTESMARKS': 'color: #009933;'
	,'KEYWORDS' : {
	    'special-operators' : 'color: #00bbdd;'
	}
	,'OPERATORS' : 'color: #FF00FF;'
	,'DELIMITERS' : 'color: #000000;'
    }
};
