# Getting started with EzSystemsCommentsBundle

## Installation

1. [Setting up the bundle](01-setup.md)
2. [Configuration](02-configuration.md)

## Usage

Comments rendering can be done with the `ez_comments.renderer` service or with the Twig helper.

### Rendering comments for an eZ Content
Useful if you want to attach comments to a given content object.

**Twig**

```jinja
{{ ez_comments_render_content( content.contentInfo ) }}
```

**PHP**

```php
/** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
/** @var \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo */
$commentsRenderer = $container->get( 'ez_comments.renderer' );
$commentsRenderer->renderForContent( $contentInfo );
```

### Rendering comments for current URL
Useful if your comments are based on the current request (e.g. from a custom controller).

**Twig**

```jinja
{{ ez_comments_render() }}
```

**PHP**
```php
/** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
$commentsRenderer = $container->get( 'ez_comments.renderer' );
$commentsRenderer->render();
```

### Overriding options
You can always override options that are set in your configuration:

```jinja
{# Assuming you're using facebook provider #}
{{ ez_comments_render_content( content.contentInfo, {'num_posts': 20, 'color_scheme': 'dark'} ) }}
```

Available options depends on each provider.
Take a look at [providers configuration](02-configuration.md#provider-configuration) to learn which options are available.

### Overriding default provider
When rendering comments, you can explicitly specify which comments provider you want to use instead of using the default one.

```jinja
{{ ez_comments_render_content( content.contentInfo, {}, 'facebook' ) }}
```
