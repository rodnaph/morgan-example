
## Morgan Example

This is a small [Silex](http://silex.sensiolabs.org) application that is meant
to demonstrate some ways to use the [Morgan](https://github.com/rodnaph/morgan)
templating library.

# Usage

First, clone the repository, and then fetch the dependencies with
[Composer](http://getcomposer.org).

```
git clone https://github.com/rodnaph/morgan-example.git
cd morgan-example
php composer.phar install
```

Then copy the _web/.htaccess-sample_ file to _web/.htaccess_, change the
_RewriteBase_ to the URL root the site will be served from, and then open
it in your browser.

