## Laravel deployment bench

This are mainly for laravel application deployment purpose within single command line application written in PHP.

Disclaimer: Experimental tools and only support for ubuntu and nginx only.


### Install
```
git clone <repository>
```

```
composer install
```

```
cp laradep.example.yaml laradep.yaml
```

### Available commands
- 1. Create project from repository.
- 2. Setup database.
- 3. Setup logging files related for current project.
- 4. Setup vhost for nginx server. 
- 5. Setup ssl using letsencrypt.



#### Create and deploy with http config for laravel application
``` 
php bin/laradep laradep:deploy <project_name>
```

Or using single line command interface to build what you need only.

#### Create project from repository
``` 
php bin/laradep laradep:clone_project <project_name> <project_origin_repository>
```

#### Create Logging for Nginx
``` 
php bin/laradep laradep:create_logging <project_name>
```

#### Create Virtual host via Nginx
``` 
php bin/laradep laradep:create_vhost <project_name>
```


__Author__ : tajul@codexpert.my
