# freetextsearch

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

# Conifiguration
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
[link-travis]: https://travis-ci.org/suilven/freetextsearch
[link-scrutinizer]: https://scrutinizer-ci.com/g/suilven/freetextsearch/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/suilven/freetextsearch
[link-downloads]: https://packagist.org/packages/suilven/freetextsearch
[link-author]: https://github.com/gordonbanderson
[link-contributors]: ../../contributors
