# Built-In CacheResolver

* [Web path](cache-resolver/web_path.md)
* [AmazonS3](cache-resolver/amazons3.md)
* [AwsS3](cache-resolver/aws_s3.md) - for SDK version 2
* [CacheResolver](cache-resolver/cache.md)
* [ProxyResolver](cache-resolver/proxy.md)

# Changing the default cache resolver

The default cache is a web path cache that caches images under `{web}/media/cache/`.
You can specify the cache to use per individual filter_sets. To change the defaults,
you can either change the top level `cache` option to the name of the cache resolver
you want to use by default, or redefine the default cache resolver by explicitly
defining a resolver called `default`:

 ```yaml
liip_imagine:
    resolvers:
        default:
            web_path:
                cache_prefix: custom_path
 ```

# Custom cache resolver

The ImagineBundle allows you to add your custom cache resolver classes. The only
requirement is that each cache resolver loader implement the following interface:

    Liip\ImagineBundle\Imagine\Cache\Resolver\ResolverInterface

To tell the bundle about your new cache resolver, register it in the service
container and apply the `liip_imagine.cache.resolver` tag to it (example here in XML):

``` xml
<service id="acme_imagine.cache.resolver.my_custom" class="Acme\ImagineBundle\Imagine\Cache\Resolver\MyCustomCacheResolver">
    <tag name="liip_imagine.cache.resolver" resolver="my_custom_cache" />
    <argument type="service" id="filesystem" />
    <argument type="service" id="router" />
</service>
```

For more information on the service container, see the Symfony2
[Service Container](http://symfony.com/doc/current/book/service_container.html) documentation.

You can set your custom cache reslover by adding it to the your configuration as the new
default resolver as follows:

``` yaml
liip_imagine:
    cache: my_custom_cache
```

Alternatively you can only set the custom cache resolver for just a specific filter set:

``` yaml
liip_imagine:
    filter_sets:
        my_special_style:
            cache: my_custom_cache
            filters:
                my_custom_filter: { }
```

For an example of a cache resolver implementation, refer to
`Liip\ImagineBundle\Imagine\Cache\Resolver\WebPathResolver`.

[Back to the index](index.md)
