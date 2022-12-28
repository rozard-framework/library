# Rozard Library
wordpress rozard library engine


## Installasi

1. aktivkan mode multisite wordpress terlebih dahulu
2. Clone repository di luar dari directory wodpress, /var/www/html
3. tambahkan baru berikut pada bagian paling bawah file wp-config.php


```
/** Sets up WordPress extended directory. */
if ( ! defined( 'EXTPATH' ) ) {
	define( 'EXTPATH', dirname( ABSPATH , 2 ) ); 
}

/** Sets up WordPress extended vars and included files. */
require_once EXTPATH . '/rozard-library/initialize.php';
```

4. masukan baris berikut sebelum `/* That's all, stop editing! Happy publishing. */` pada file wp-config.php

```
/** ROZARD - SECURITY */
define( 'DISALLOW_FILE_EDIT', false );
define( 'DISALLOW_FILE_MODS', false );

/** ROZARD - PERFORMA */
define( 'DISABLE_WP_CRON', true);
define( 'AUTOSAVE_INTERVAL', 300); // seconds
define( 'WP_POST_REVISIONS', false);
define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M');
define( 'WP_CACHE', true);
```
