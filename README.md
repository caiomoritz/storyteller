# Storyteller

BDD style DSL and test suite runner for PHP 7+

## Installation

The only supported method of installation is via Composer:

```
$ php composer.phar require --dev caiomoritz/storyteller
```

Composer will place the Storyteller test runner in `vendor/bin/storyteller`.

## Sample usage

Sample story file defining a single assertion:

```php
<?php // Contents of tests/MyFirstStory.php

use function Storyteller\{describe, context, should, expect};
use function Storyteller\Matcher\{equal};

describe("a user logged into the admin panel", function() {
    context('with access to a single module (products)', function() {
        should('be authorized into the products module only', function() {
            expect($authorizedModules)->to(equal(['products']));
        });
    });
});
```

Run your stories as a test suite:

```
$ cd your-project-root
$ php vendor/bin/storyteller
```

Storyteller will look for story files in the current working directory recursively. All files ending with the `Story.php` suffix are currently considered story files.
