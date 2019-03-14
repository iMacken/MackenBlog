## 项目概述

* 产品名称：MackenBlog
* 项目代码：MackenBlog
 
[MackenBlog](https://github.com/RystLee/MackenBlog) Laravel 5.3 版本。
 
## 运行环境
 
 - Nginx 1.8+
 - PHP 5.6.4+
 - Mysql 5.5+
 
## 开发环境部署/安装
 
 本项目代码使用 PHP 框架 [Laravel 5.3](https://doc.laravel-china.org/docs/5.1/) 开发，本地开发环境使用 [DevDock](https://github.com/RystLee/DevDock)。
 
### 基础安装
 
#### 1. 克隆源代码
 
 克隆源代码到本地：
     > git clone https://github.com/RystLee/MackenBlog.git
 
#### 3. 安装扩展包依赖
 
     > composer install
 
#### 4. 生成配置文件
 
     > cp .env.example .env
 
#### 5. 安装数据库
 
 ```shell
 php artisan migrate
 php artisan seed:db
 ```
 默认用户为 admin@admin.com  密码为 asdasd
 
### 前端工具集安装
 
 1). 安装 node.js
 
 直接去官网 [https://nodejs.org/en/](https://nodejs.org/en/) 下载安装最新版本。
 
 2). 安装 Gulp
 
 ```shell
 npm install --global gulp
 ```
 
 3). 安装 Laravel Elixir
 
 ```shell
 npm install
 ```
 
 4). 直接 Gulp 编译前端内容
 
 ```shell
 gulp
 ```
 
 5). 监控修改并自动编译
  
 ```shell
 gulp watch
 ```
 
## License
 
 MIT
