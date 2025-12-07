# El-Tawkeel documentation & manual guide

## Code Architecture

- any existing migration should be used
- restricted to best naming convention seo_metas (with model also)
- isolate web routes (web.php), admin routes (admin.php), and artisan calls routes (artisan.php)
- routes will be grouped (by prefix users , group by controller , group by middleware , group by name as)
- restricted to best route naming architecture and route paths orders/{orderId}/product/{id}/edit (named route)
- route -> controller
        -> validation (form request file)
        -> repo (for query getAll , getBy , createOrUpdate)
        -> service (for business logic)
        -> repo and service will be registered via controller contractor
        -> for repeated queries use scopes in model

- naming of blades is very important

************** KEEP IT SIMPLE UNTIL IT NEED TO BE COMPLEX *****************
