# Free Text Search
[![Build Status](https://travis-ci.org/gordonbanderson/freetextsearch.svg?branch=CODE_COVERAGE)](https://travis-ci.org/gordonbanderson/freetextsearch)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gordonbanderson/freetextsearch/badges/quality-score.png?b=CODE_COVERAGE)](https://scrutinizer-ci.com/g/gordonbanderson/freetextsearch/?branch=CODE_COVERAGE)
[![codecov.io](https://codecov.io/github/gordonbanderson/freetextsearch/coverage.svg?branch=CODE_COVERAGE)](https://codecov.io/github/gordonbanderson/freetextsearch?branch=CODE_COVERAGE)


[![Latest Stable Version](https://poser.pugx.org/suilven/freetextsearch/version)](https://packagist.org/packages/suilven/freetextsearch)
[![Latest Unstable Version](https://poser.pugx.org/suilven/freetextsearch/v/unstable)](//packagist.org/packages/suilven/freetextsearch)
[![Total Downloads](https://poser.pugx.org/suilven/freetextsearch/downloads)](https://packagist.org/packages/suilven/freetextsearch)
[![License](https://poser.pugx.org/suilven/freetextsearch/license)](https://packagist.org/packages/suilven/freetextsearch)
[![Monthly Downloads](https://poser.pugx.org/suilven/freetextsearch/d/monthly)](https://packagist.org/packages/suilven/freetextsearch)
[![Daily Downloads](https://poser.pugx.org/suilven/freetextsearch/d/daily)](https://packagist.org/packages/suilven/freetextsearch)
[![composer.lock](https://poser.pugx.org/suilven/freetextsearch/composerlock)](https://packagist.org/packages/suilven/freetextsearch)

[![GitHub Code Size](https://img.shields.io/github/languages/code-size/gordonbanderson/freetextsearch)](https://github.com/gordonbanderson/freetextsearch)
[![GitHub Repo Size](https://img.shields.io/github/repo-size/gordonbanderson/freetextsearch)](https://github.com/gordonbanderson/freetextsearch)
[![GitHub Last Commit](https://img.shields.io/github/last-commit/gordonbanderson/freetextsearch)](https://github.com/gordonbanderson/freetextsearch)
[![GitHub Activity](https://img.shields.io/github/commit-activity/m/gordonbanderson/freetextsearch)](https://github.com/gordonbanderson/freetextsearch)
[![GitHub Issues](https://img.shields.io/github/issues/gordonbanderson/freetextsearch)](https://github.com/gordonbanderson/freetextsearch/issues)

![codecov.io](https://codecov.io/github/gordonbanderson/freetextsearch/branch.svg?branch=CODE_COVERAGE)


This module allows configuration of freetext search indexes, and provides tools to create indexes and reindex them.
By default only a sitetree index is configured, but one can add indexes for subclasses of SiteTree (e.g. a BlogPost)
or a DataObject only index, e.g. flickr photos.  The template for rendering the search results can also be overridden.

Note that one also has to install an implementation, currently only one for Manticore Search (formerly Sphinx) exists,
package name is `suilven/silverstripe-manticore-search`

# Configuration
## Indexes
By default the core fields of SiteTree are indexed.  You can override as follows to allow for third party modules or
your own.  Each index should map to a model class, and the field names match those in the database.

An example follows, code can be found at https://github.com/gordonbanderson/flickr-editor/tree/upgradess4


```yml
---
Name: flickrfreetextsearch
After: freetextindexes
---

Suilven\FreeTextSearch\Indexes:
  indexes:
```
The above is compulsory.  Additional indexes start here.
```yml
    - index:
```
The name of the index
```yml
        name: flickrphotos
```
The class of DataObject being indexed
```yml
        class: Suilven\Flickr\Model\Flickr\FlickrPhoto
```
These fields are indexed as free text.
```yml       
        fields:
          - Title
          - Description
```
It is not always desirable to show highlights from all of the fields, this is a filter list of fields to render highlights
from in search results.
```yml
        highlighted_fields:
          - Title
          - Description
```
These fields are stored but not searchable.  Their function is to provide fields to render in the search results, and
avoid hydrating objects from the database.  Note that Link is a hybrid field, the existence of a `Link()` method is
checked for at indexing time and the field added if the method exists.
```yml
        stored_fields:
          - ThumbnailURL
          - Link
```
---
The following indexes correctly with Manticoresearch, but note that the ManticoreSearch PHP client does not currently
allow for facetted searching.  It is in pipeline though.  Raw queries show facetted groups returned, but it makes sense
to wait for this to be implemented in the PHP client instead.
---
Fields that can be used for facetted searching.  
```yml
        tokens:
          - Aperture
          - ShutterSpeed
          - ISO
          - TakenAt
```

Have one fields are effectively another facet.
```yml
        has_one:
          - Suilven\Flickr\Model\Flickr\FlickrAuthor

```
This example shows how to index a has many field, tags, for facetting.  Each entry has 3 fields:
* `name`: the name of the relationship
* `relationship`: The SilverStripe name of the relationship
* `field`: The `FlickrTags` relationship is a data list of `FlickrTag`, the value stored is that of the `RawValue` field.
```yml
        has_many:
          -
            name: tags
            relationship: FlickrTags
            field: RawValue

```

## Extensions
Any class referenced in indexes configuration needs the following extension, 
`Suilven\FreeTextSearch\Extension\IndexingExtension`, added.  This performs one of two jobs:
1) Index a DataObject immediately after it's been saved
2) /or mark a DataObject as dirty and add a job to the queue to process the indexes affected.

```yml
---
Name: freetextindexes-flickr
After: freetextindexes-extensions
---

Suilven\Flickr\Model\Flickr\FlickrPhoto:
  extensions:
    - Suilven\FreeTextSearch\Extension\IndexingExtension
```

## Indexing Mode
In the site configuration there is an additional tab called Free Text Search.  It contains two fields:

* `FreeTextSearchIndexingModeInBulk` - tick this to index in bulk via queue, untick to index immediately after writing
to the database
* `BulkSize` - the number of DataObjects to index at once

## Install
Via Composer

``` bash
$ composer require suilven/freetextsearch
```

## Usage

## Indexing
Note that these commands require an implementation of freetextsearch.

### Creating an Index
Change the name of the index as appropriate.  Note that when this command is run, the contents of the index will be
dropped, and a reindex will be required.
```
vendor bin/sake dev/tasks/create-index index=sitetree
```

### Reindexing an Index
Change the name of the index as appropriate.  This will reindex in bulk.
```
vendor bin/sake dev/tasks/reindex index=sitetree
```

## Adding a Search Page for an Index
In the CMS add a page of type `Search Page`.  The following fields are editable:
* `IndexToSearch` - the index to search, e.g. `sitetree` or `flickrphotos`
* `PageSize` - the number of search results to return per page

The following are related to facets and not yet implemented:
* `ShowAllIfEmptyQuery` - if this is ticked, search results will be shown for an empty query
* `ShowTagCloudFor` - show tag cloud for a faceted field when there are no search results to be shown
        

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit tests '' flush=1
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email gordon.b.anderson@gmail.com instead of using the issue tracker.

## Credits

- [Gordon Anderson][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/suilven/freetextsearch.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/suilven/freetextsearch/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/suilven/freetextsearch.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/suilven/freetextsearch.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/suilven/freetextsearch.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/suilven/freetextsearch
[link-downloads]: https://packagist.org/packages/suilven/freetextsearch
[link-author]: https://github.com/gordonbanderson
[link-contributors]: ../../contributors
