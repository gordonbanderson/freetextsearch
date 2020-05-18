# Free Text Search Base
[![Build Status](https://travis-ci.org/gordonbanderson/freetextsearch.svg?branch=FIX_CI)](https://travis-ci.org/gordonbanderson/freetextsearch)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gordonbanderson/freetextsearch/badges/quality-score.png?b=FIX_CI)](https://scrutinizer-ci.com/g/gordonbanderson/freetextsearch/?branch=FIX_CI)
[![Build Status](https://scrutinizer-ci.com/g/gordonbanderson/freetextsearch/badges/build.png?b=FIX_CI)](https://scrutinizer-ci.com/g/gordonbanderson/freetextsearch/build-status/FIX_CI)
[![CircleCI](https://circleci.com/gh/gordonbanderson/freetextsearch.svg?style=svg)](https://circleci.com/gh/gordonbanderson/freetextsearch)

[![codecov.io](https://codecov.io/github/gordonbanderson/freetextsearch/coverage.svg?branch=FIX_CI)](https://codecov.io/github/gordonbanderson/freetextsearch?branch=FIX_CI)


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

![codecov.io](https://codecov.io/github/gordonbanderson/freetextsearch/branch.svg?branch=FIX_CI)

# **** WORK IN PROGRESS ****

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

# Configuration
By default the core fields of SiteTree are indexed.  You can override as follows to allow for third party modules or
your own.  Each index should map to a model, and the field names match those in the database.  Each index sub YML
contains the following:

* name:  This will be come the index name in the SphinxSQL database
* class:  The SilverStripe class being indexed
* fields:  The fields to index

Optionally the following may be added.

* tokens:  Stores the field as it with no stemming.  Used for facetted search
* has_one: A list of SilverStripe model class names.  The is effectively a filter by id
* has_many: 
* has_many_many: (@todo check this)

An example follows:


```yml
---
Name: freetextindexes2
After: freetextindexes
---

# Define indexes
Suilven\FreeTextSearch\Indexes:
  indexes:
    - index:
        name: blogposts
        class: SilverStripe\Blog\Model\BlogPost
        fields:
          - Title
          - MenuTitle
          - Content
          - ParentID
          - Sort
          - PublishDate
          - AuthorNames
          - Summary

    - index:
        name: comments
        class: SilverStripe\Comments\Model\Comment
        fields:
          - Email
          - Comment
          - AuthorID
          - ParentCommentID
          - Name
          - URL

    - index:
        name: flickr
        class: Suilven\Flickr\Model\FlickrPhoto

        # Free text searchable
        fields:
          - Title
          - Description

        # Facets or filterable
        tokens:
          - Aperture
          - ShutterSpeed
          - ISO

        has_many_many:
          - Suilven\Flickr\Model\FlickrSet

        # Effectively another token filter, but by ID
        has_one:
          - Suilven\Flickr\Model\FlickrAuthor

        # MVA
        has_many:
          - Suilven\Flickr\Model\FlickrTag

```




index testrt {
    type = rt
    rt_mem_limit = 128M
    path = /var/lib/manticore/data/testrt
    rt_field = title
    rt_field = content
    rt_attr_uint = gid
}

searchd {
    listen = 9312
    listen = 9308:http
    listen = 9306:mysql41
    log = /var/lib/manticore/log/searchd.log
    # you can also send query_log to /dev/stdout to be shown in docker logs
    query_log = /var/lib/manticore/log/query.log
    read_timeout = 5
    max_children = 30
    pid_file = /var/run/searchd.pid
    seamless_rotate = 1
    preopen_indexes = 1
    unlink_old = 1
    binlog_path = /var/lib/manticore/data
}



















-----------------------------

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require suilven/freetextsearch
```

## Usage

``` php
$skeleton = new Suilven\FreeTextSearch();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
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
