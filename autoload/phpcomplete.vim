let s:save_cpo = &cpo
set cpo&vim

echom "Running"

function! phpcomplete#test() " {{{
    echom "We are live"
endfunction "}}}

function! phpcomplete#CompletePHP(findStart, base) " {{{
    let a = s:get_complete_context()
    
    return {'words': ['Gareth'], 'refresh': 'always'}
endfunction "}}}

" @return completeContext { };
"       fqcn:   Probably the fully qualified name of the token. Taken
"               from s:guessTypeOfParsedTokens
"       lastToken:
"       last_resolutor:
"       complete_type:  enum('class', 'use', 'new')
"                       class: The default complete type
"                       use: Completion for namespaces
"                       new: Completion if you're creating a class or
"                           extending from a class
"                       insideQuote: Not entirely sure. Name is suggestive
"                       nonclass:
"                                   
function! s:get_complete_context() "{{{
    "Get the current line up to 2 characters before the cursor
    let cursorLine = getline('.')[0:col('.')-2]
    if !exists('phpcomplete_extended_context')
        let completeContext = {}
    endif

    " Default to class context
    let completeContext.complete_type = "class"

    " If this line starts with a use, enable use context
    if cursorLine =~? '^\s*use\s\+'
        " namespace completeion
        let completeContext.complete_type = "use"

    elseif cursorLine =~? '\(\s*new\|extends\)\s\+'
            \ && len(phpcomplete_extended#parsereverse(cursorLine, line('.'))) == 1
        "new class completion
        let completeContext.complete_type = "new"
    else
        if !phpcomplete_extended#is_phpcomplete_extended_project()
            return {}
        endif
        let parsedTokens = phpcomplete_extended#parsereverse(cursorLine, line('.'))

        if empty(parsedTokens)
            let  completeContext = {}
            return {}
        endif

        if has_key(parsedTokens[0], "nonClass") && parsedTokens[0]["nonClass"]
            let completeContext.complete_type = "nonclass"
        elseif has_key(parsedTokens[-1], "insideQuote")
            let lastToken = remove(parsedTokens, -1)
            let fqcn = s:guessTypeOfParsedTokens(deepcopy(parsedTokens))
            let completeContext.lastToken = lastToken
            let completeContext.lastToken['insideBraceText'] = matchstr(lastToken['insideBraceText'], '[''"]\?\zs.*\ze[''"]\?')
            let completeContext.fqcn = fqcn
            let completeContext.complete_type = "insideQuote"
        else
            let lastToken = remove(parsedTokens, -1)
            let fqcn = s:guessTypeOfParsedTokens(deepcopy(parsedTokens))
            let completeContext.complete_type = "class"
            let completeContext.last_resolutor = matchstr(cursorLine, '.*\zs\(->\|::\)\ze.*')

            let completeContext.lastToken = lastToken
            let completeContext.fqcn = fqcn
        endif
    endif
    return completeContext

endfunction "}}}

let &cpo = s:save_cpo
unlet s:save_cpo
