FineDiff
========

Originally written by Raymond Hill ([https://github.com/gorhill/PHP-FineDiff](https://github.com/gorhill/PHP-FineDiff))
[![Build Status](https://travis-ci.org/cogpowered/FineDiff.png?branch=master)](https://travis-ci.org/cogpowered/FineDiff)

Installation
------------

**Composer**

The preferred way of using FineDiff is through [Composer](http://getcomposer.org).

```shell script
composer require d4h/finediff
```

Usage
-----

**Render HTML**

Render the difference between two strings as HTML:

```php
$diff = new FineDiff\Diff();
echo $diff->render('string one', 'string two');
```

This would then output:

```html
string <ins>tw</ins>o<del>ne</del>
```

You could change the granularity to `CogPowered\FineDiff\Granularity\Word`

```php
$diff = new FineDiff\Diff(new FineDiff\Granularity\Word());
// Or via the setter method:
$diff->setGranularity(new FineDiff\Granularity\Word());
```

so the output is:

```html
string <del>one</del><ins>two</ins>
```

You do this by passing it into the Diff constructor:

**Grab opcode instructions**

Opcode instructions are what tell FineDiff how to change one string into another.

```php
$diff = new FineDiff\Diff();
echo $diff->getOpcodes('string one', 'string two');
```

This would then output:

```html
c7d3i3:two
```

Render text using the opcodes:
```php
$renderer = new FineDiff\Render\Text();
echo $renderer->process('string one', 'c7d3i3:two');
```

Would output:
```html
string two
```

Same with HTML:
```php
$renderer = new FineDiff\Render\Html();
echo $renderer->process('string one', 'c7d3i3:two');
```
