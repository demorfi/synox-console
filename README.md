# SynoX Web API

Implementation of the API interface for [SynoX Web](https://github.com/demorfi/synox-web)

## Composer Installation
```bash
composer require demorfi/synox-web-api
```

### Basic Usage
```php
$api = new \SynoxWebApi\Api('https://synox-web.domain/api/');
```

### Search Usage
```php
$search = $api->search();
$search->makeFilters()->addCategory('video')->addPackage('tpb'); // optional make filters
$profile = null; // optional profile name 
foreach ($search->create('Silent Hill', $profile)->run() as $item) {
    printf("Title: %s; Size: %s\n", $item->getTitle(), $item->getWeight());
    // download only this torrent file
    if (stripos($item->getTitle(), 'Silent Hill 2') !== false) {
        // $item->getFetchId(); fetched id for download
        file_put_contents('file.torrent', $item->fetch()->download());
        return;
    }
}
```

### Download Usage
```php
$fetched = $api->content()->fetch('tpb', 'fetch id');
//$fetched->downloadUrn(); only URN path to torrent file
file_put_contents('file.torrent', $fetched->download());
```

### Change Package State
```php
$api->packages()->changeState('tpb', true); // enable this package
```

## Reporting issues
If you have any issues with the application please open an issue on [GitHub](https://github.com/demorfi/synox-web-api/issues).

## License
SynoX Web is licensed under the [MIT License](http://www.opensource.org/licenses/mit-license.php).