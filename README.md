# Rozard Library
wordpress rozard library engine


## Installasi

1. Aktivkan mode multisite wordpress terlebih dahulu
2. buat file dengan nama wp-setting.php dan isikan file dengan syntax di bawah


```
/** REGISTER LIBRARY  */
if ( ! defined( 'ABPSATH' ) ) {
	define( 'ABPSATH', __DIR__ . '/wp-admin/library/' ); 
}


require_once  ABPSATH . 'loader.php';
define('WPMU_PLUGIN_DIR',  ABSPATH .'wp-admin/module/');
require_once  ABSPATH . 'wp-settings.php';
```

3. masukan baris berikut sebelum `/* That's all, stop editing! Happy publishing. */` pada file wp-config.php

```
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once  ABSPATH . 'wp-setting.php';
```

4. clone rozard module dari github
