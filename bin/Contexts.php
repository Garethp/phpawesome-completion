<?php

namespace Indexer;

class Contexts
{
    const CONTEXT_NAMESPACE = 'NamespaceContext';
    const CONTEXT_CLASS_NAME = 'ClassNameContext';
    const CONTEXT_NONE = 'NoContext';
    const CONTEXT_IN_PHP = 'InPHPContext';
    const CONTEXT_PROPERTY = 'PropertyContext';
    const CONTEXT_SIGNATURE_METHOD = 'MethodSignatureContext';
    const CONTEXT_METHOD_ARGUMENT = 'MethodArgumentContext';
    const CONTEXT_METHOD_IN_METHOD = 'InsideMethodContext';
    const CONTEXT_METHOD_RETURN_TYPE = 'MethodReturnTypeContext';
    const CONTEXT_USE_STATEMENT = 'UseStatementContext';
    const CONTEXT_IN_CLASS = 'InClassContext';
    const CONTEXT_CLASS_SIGNATURE = 'ClassSignatureContext';
}
