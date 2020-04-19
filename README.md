# Larasquad Filter

This package allows you to filter resource based on a request in a simple way and makes you controller code clean.

## Basic usage
Make a filter class and extend it by 
```bash
use Larasquad\Filter\Filter
```
or, you can generate it by 
```bash
php artisan make:filter User
```
It will generate a filter class on you app\Filters directory.
```php
<?php
namespace  App\Filters;

use Larasquad\Filter\Filter;

class  UserFilter  extends  Filter
{

//

}
```
Now, inject the class in you controller method where you have injected the `Request $request`  class
```php

public  function  index(Request $request)
{
	//
}
```

Replace the `Request $request` from your method  with `UserFilter $filter`

```php

public  function  index(UserFilter $filter)
{
	//
}
```

It will automaticall initiate the `Request $request`  in it's parent constructor.
Now use the `Filterable` trait in you model.
```php
use Larasquad\Filter\Traits\Filterable;

class  User  extends  Authenticatable
{
	use Filterable;
}
```
It's done. Now you can you the `filter` method in your controller and pass the `$filter` object in the method.
```php

public  function  index(UserFilter $filter)
{
	$users = User::filter($filter)->get();
	return  view('pages.users.index', compact('users'));
}
```
By default, It filters the model by using `Laravel` default `where` clause.
Here,  `$request` input name is used as column and `$request` input value is used as `search value` 
You can override the `search query` by writing a method on your `Filter Class` . You have to name it like the `model` database column name or the `camelCase` or `snake_case` of it.
```php
/**
* Filters the first_name column of the resource
*
* @return  void
*/
public  function  firstName($value)
{
	$this->query->where('first_name', 'like', "%{$value}%");
}
```
## License

The MIT License (MIT)
