## Docker installation
1. Install [docker](https://docs.docker.com/engine/installation/), [docker-compose](https://docs.docker.com/compose/install/) and [composer](https://getcomposer.org/) to your system
2. Run ``composer run-script docker:start``
3. That's all - your application is accessible on [http://yii2-starter-kit.localhost](http://yii2-starter-kit.localhost)

 * - docker host IP address may vary on Windows and MacOS systems
 
*PS* Also you can use bash inside application container. To do so run `docker-compose exec app bash`
*PS* If app does not work right, check docker image name using `docker ps -a`

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

