editAreaLoader.load_syntax["haskell"] = {
    'DISPLAY_NAME' : 'Haskell'
    ,'COMMENT_SINGLE' : {1 : '--'}
    ,'COMMENT_MULTI' : {'{-' : '-}'}
    ,'QUOTEMARKS' : {1: '"', 2: "'"}
    ,'KEYWORD_CASE_SENSITIVE' : true
    ,'KEYWORDS' : {
        'keywords' : [
                'as', 'case', 'of', 'class', 'data', 'default',
                'deriving', 'do', 'forall', 'hiding',
                'if', 'then', 'else', 'import', 'infix', 'infixl',
                'infixr', 'instance', 'let', 'in', 'module', 'newtype',
                'qualified', 'type', 'where'
        ]
        ,
        'types' : [
                'Bool', 'Maybe', 'Either', 'Ordering', 'Char',
                'Int', 'Integer', 'Float', 'Double', 'IO', 'String',
                'Rational', 'ShowS', 'ReadS', 'FilePath', 'IOError',
                'Eq', 'Ord', 'Enum', 'Bounded', 'Num', 'Real',
                'Integral', 'Fractional', 'Floating', 'RealFrac',
                'RealFloat', 'Monad', 'Functor', 'Show', 'Read'
        ]
        ,
        'prelude' : [
                'False', 'True', 'not', 'otherwise', 'Nothing', 'Just',
                'maybe', 'Left', 'Right', 'either', 'LT', 'EQ', 'GT',
                'fst', 'snd', 'curry', 'uncurry', 'compare', 'max', 'min',
                'succ', 'pred', 'toEnum', 'fromEnum', 'enumFrom',
                'enumFromThen', 'enumFromTo', 'enumFromThenTo',
                'minBound', 'maxBound', 'negate', 'abs', 'signum',
                'fromInteger', 'toRational', 'quot', 'rem', 'div', 'mod',
                'quotRem', 'divMod', 'toInteger', 'recip', 'fromRational',
                'pi', 'exp', 'sqrt', 'log', 'logBase', 'sin', 'tan', 'cos',
                'asin', 'atan', 'acos', 'sinh', 'tanh', 'cosh',
                'asinh', 'atanh', 'acosh', 'properFraction', 'truncate',
                'round', 'ceiling', 'floor', 'floatRadix', 'floatDigits',
                'floatRange', 'decodeFloat', 'encodeFloat', 'exponent',
                'significand', 'scaleFloat', 'isNaN', 'isInfinite',
                'isDenormalized', 'isNegativeZero', 'isIEEE', 'atan2',
                'subtract', 'even', 'odd', 'gcd', 'lcm', 'fromIntegral',
                'realToFrac', 'return', 'fail', 'fmap', 'mapM', 'mapM_',
                'sequence', 'sequence_', 'id', 'const', 'flip', 'until',
                'asTypeOf', 'error', 'undefined', 'seq', 'map', 'filter',
                'head', 'last', 'tail', 'init', 'null', 'length',
                'reverse', 'foldl', 'foldl1', 'foldr', 'foldr1',
                'and', 'or', 'any', 'all', 'sum', 'product', 'concat',
                'concatMap', 'maximum', 'minimum', 'scanl', 'scanl1',
                'scanr', 'scanr1', 'iterate', 'repeat', 'replicate',
                'cycle', 'take', 'drop', 'splitAt', 'takeWhile',
                'dropWhile', 'span', 'break', 'elem', 'notElem',
                'lookup', 'zip', 'zip3', 'zipWith', 'zipWith3',
                'unzip', 'unzip3', 'lines', 'words', 'unlines', 'unwords',
                'showsPrec', 'show', 'showList', 'shows', 'showChar',
                'showString', 'showParen', 'readsPrec', 'readList',
                'reads', 'readParen', 'read', 'lex', 'putChar', 'putStr',
                'putStrLn', 'print', 'getChar', 'getLine', 'getContents',
                'interact', 'readFile', 'writeFile', 'appendFile',
                'readIO', 'readLn', 'ioError', 'userError'
        ]
    }
    ,'OPERATORS' : [
            '&&', '||', '==', '/=', '<', '>=', '>', '<=',
            '+', '*', '-', '/', '**', '^', '^^', '>>=', '>>', '=<<',
            '.', '$', '$!', '++', '!!'
    ]
    ,'DELIMITERS' : [
            '(', ')', '{', '}', ';'
    ]
    ,'STYLES' : {
            'COMMENTS' : 'color: #6666FF;'
            ,'QUOTEMARKS' : 'color: #CC3300;'
            ,'KEYWORDS' : {
                    'keywords' : 'color: #993300;'
                    ,'types'   : 'color: #00BBDD;'
                    ,'prelude' : 'color: #00BBDD;'
            }
            ,'OPERATORS' : 'color: #FF9933;'
            , 'DELIMITERS' : 'color: #FFFFFF;'
    }
}
