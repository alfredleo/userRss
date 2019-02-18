1) User registration - form with e-mail and password fields + e-mail verification using ajax. 
Existence of already registered e-mail should be checked “on the fly” via ajax call when writing e-mail address and before submitting form. 
After registration user should receive confirmation e-mail. 
2) Login form with e-mail address and password 
Logins are permitted only for successfully verified e-mail addresses. 
3) RSS feed view 
After successful login display top 20 news from following RSS feed https://www.delfi.lv/rss/?channel=delfi

You should do this task by showing your best experience in UX, UI, backend stuff. 
There are no restrictions on frameworks (PHP and/or JS) used.



## Docker installation
1. Install [docker](https://docs.docker.com/engine/installation/), [docker-compose](https://docs.docker.com/compose/install/) and [composer](https://getcomposer.org/) to your system (that is host machine)
2. Run ``cp .env-dist .env`` to copy config file and ``composer run-script docker:start`` to start, ``docker-compose exec app composer install && docker-compose exec app console/yii app/setup``
3. That's all - your application is accessible on [http://yii2-starter-kit.localhost](http://yii2-starter-kit.localhost)

 * - docker host IP address may vary on Windows and MacOS systems
 
*PS* Also you can use bash inside application container. To do so run `docker-compose exec app bash`
*PS* If app does not work right, check docker image name using `docker ps -a`
*PS* To start fresh docker run ``docker-compose down --volumes --remove-orphans && docker system prune -a``

### Docker FAQ
1. How do i run yii console commands from outside a container?

``docker-compose exec app console/yii help``

``docker-compose exec app console/yii migrate``

``docker-compose exec app console/yii rbac-migrate``

2. How to connect to the application database with my workbench, navicat etc?
MySQL is available on `yii2-starter-kit.localhost`, port `3306`. User - `root`, password - `root`

## Demo data
```
Login: webmaster
Password: webmaster

Login: manager
Password: manager

Login: user
Password: user
```

## How do i access mailcatcher?
In docker installation mailcatcher is running on [yii2-starter-kit.localhost:1080](yii2-starter-kit.localhost:1080)


# Testing

To run tests:
1. Start containers:
```
docker-compose up -d
```
2. Create `tests` database:
windows version
linux version
```
docker-compose exec db mysql -uroot -proot -e "CREATE DATABASE `yii2-starter-kit-test` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci" 
docker-compose exec db mysql -uroot -proot -e "CREATE DATABASE \`yii2-starter-kit-test\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci" 
```
3. Build needed files
```
docker-compose exec app ./vendor/bin/codecept build
```
4. Setup application:
```
docker-compose exec app php tests/bin/yii app/setup --interactive=0
```
5. Start web server for acceptance tests (do not close bash session):
```
docker-compose exec app php -S localhost:8080
```
6. Run tests in separate window:
```
docker-compose exec app vendor/bin/codecept run
```

## RSS media parse function
Add this method to Zend\Feed\Reader\Entry\Rss if need pictures of entries. Library should be updated to work with images.
```php
    public function getMedia()
    {
        if (array_key_exists('media', $this->data)) {
            return $this->data['media'];
        }

        $media = null;

        if ($this->getType() == Reader\Reader::TYPE_RSS_20) {
            $nodeList = $this->xpath->query($this->xpathQueryRss . '/media:content');

            if ($nodeList->length > 0) {
                $media = new \stdClass();
                $media->url    = $nodeList->item(0)->getAttribute('url');

            }
        }
        $this->data['media'] = $media;

        return $this->data['media'];
    }
```