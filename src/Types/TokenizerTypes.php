<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Types;

class TokenizerTypes
{
    public const NONE = 'none';

    // stemmers
    public const SNOWBALL = 'snowball';
    public const PORTER = 'porter';

    // possibly manticore specific
    public const LEMMATIZER = 'lemmatizer';

    // ---- phonetic tokenizers ----
    public const METAPHONE = 'metaphone';
    public const SOUNDEX = 'soundex';

}
