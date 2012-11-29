editAreaLoader.load_syntax["scm"] = {
    'DISPLAY_NAME' : 'Scheme'
    ,'COMMENT_SINGLE' : {1 : ';', 2:';;'}
    ,'COMMENT_MULTI' : {'#|' : '|#'}
    ,'QUOTEMARKS' : ['"']
    ,'KEYWORD_CASE_SENSITIVE' : false
    ,'KEYWORDS' : {
	'symbols' : [
	    '*', '+', '-', '...', '/', '<', '<=', '>=', 'abs', 'acos',
	    'and', 'angle', 'apply', 'asin', 'assoc', 'assq', 'assv',
	    'atan', 'begin', 'boolean?', 'caar', 'cadr',
	    'call-with-current-continuetion', 'call-with-input-file',
	    'call-with-output-file', 'call-with-values', 'call/cc',
	    'car', 'case', 'catch', 'cdddar', 'cddddr', 'cdr',
	    'ceiling', 'char->integer', 'char-alphabetic?',
	    'char-ci<=?', 'char-ci<?', 'char-ci=?', 'char-ci>=?',
	    'char-ci>?', 'char-downcase', 'char-lower-case?',
	    'char-numeric?', 'char-ready?', 'char-upcase',
	    'char-upper-case?', 'char-whitespace', 'char<=?', 'char<?',
	    'char=?', 'char>=?', 'char>?', 'char?', 'close-input-port',
	    'close-output-port', 'complex?', 'cond', 'cons', 'cos',
	    'current-input-port', 'current-output-port', 'define',
	    'define-syntax', 'delay', 'denominator', 'display', 'do',
	    'dynamic-wind', 'else', 'eof-object?', 'eq?', 'equal?',
	    'eqv?', 'eval', 'even?', 'exact->inexact', 'exact?', 'exp',
	    'expt', 'floor', 'for-each', 'force', 'gcd', 'if', 'img-part',
	    'inexact->exact', 'inexact?', 'input-port?', 'integer->char',
	    'integer?', 'intaraction-environment', 'lambda', 'lcm',
	    'length', 'let', 'let*', 'let-syntax', 'letrec',
	    'letrec-syntax', 'list', 'list->string', 'list->vector',
	    'list-ref', 'list-tail', 'list?', 'load', 'log', 'magnitude',
	    'make-polar', 'make-rectanglar', 'make-string', 'make-vector',
	    'map', 'max', 'membar', 'memq', 'min', 'modulo', 'negative?',
	    'newline', 'not', 'null-environment', 'null?', 'number->string',
	    'number?', 'numerator', 'odd?', 'open-input-file',
	    'open-output-file', 'or', 'output-port?', 'pair?', 'peek-char',
	    'port?', 'positive?', 'procedure?', 'quasiquote', 'quote',
	    'quotient', 'rational?', 'rationalize', 'read', 'read-char',
	    'real-part', 'real?', 'remainder', 'reverse', 'round',
	    'scheme-report-environment', 'set!', 'set-car!', 'set-cdr!',
	    'setcar', 'sin', 'sqrt', 'string', 'string->list',
	    'string->number', 'string->symbol', 'string-append',
	    'string-ci<=?', 'string-ci<?', 'string-ci=?', 'string-ci>=?',
	    'string-ci>?', 'string-copy', 'string-fill!', 'string-length',
	    'string-ref', 'string-set!', 'string<=?', 'string<?',
	    'string=?', 'string>=?', 'string>?', 'string?', 'substring',
	    'symbol->string', 'symbol?', 'syntax-rules', 'tan',
	    'transcript-off', 'transcript-on', 'truncate', 'unquote',
	    'unquote-splicing', 'values', 'vector', 'vector->list',
	    'vector-fill!', 'vector-length', 'vector-ref', 'vector-set!',
	    'vector?', 'with-input-from-file', 'with-output-to-file',
	    'write', 'write-char', 'zero?'
	]
    }
    ,'OPERATORS' :[
    ]
    ,'DELIMITERS' :[	// Array: the block code delimiters to highlight
	'(', ')'
    ]
    ,'STYLES' : {
	// Array: an array of array, containing all style to apply for categories defined before.
	// Better to define color style only. 
	'COMMENTS': 'color: #D46633;'
	,'QUOTESMARKS': 'color: #009933;'
	,'KEYWORDS' : {
		'symbols' : 'color: #00BBDD;'
	}
	,'OPERATORS' : 'color: #FF00FF;'
	,'DELIMITERS' : 'color: #0038E1;'
    }
};
