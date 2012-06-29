# OAuth Provider Example

本项目来自[djpate/OAuthProviderExample](http://github.com/djpate/OAuthProviderExample)，
以PHP官方的oauth扩展包为基础，实现了一个
OAuth Provider **原型**(不能直接用于生产环境)。

除此以外，项目中还提供了一个简单的oauth客户端(
OAuth 1.0 RFC 5849 中称为Client/Consumer)的代码示例。

### 参考资料

1. PHP oauth官方手册，可以获得Oauth与OAuthProvider
的API指南；
2. djpate的博客 [How to write a complete OAuth Provider in PHP5](http://djpate.com/2011/01/13/how-to-write-a-complete-oauth-provider-in-php5/)
3. [OAuth的官方网站](http://oauth.net)
4. OAuth RFC 5859 & 2.0 draft & mail list

### 运行说明

运行该示例代码，以站外应用为例，假设Provider和API是同一域名主机（例如新浪微博），
站外应用是另外一台独立主机。在示例部署时，仅需将源码中client目录部署在站外
应用所在服务器上（访问地址是http://192.168.100.100/client），
Provider和API服务部署在另外一台服务器上(访问地址是http://192.168.100.120)。

按照OAuth 1.0 规范中规定的protocol endpoints，本例中分别是：

 - Request Token URI: http://192.168.100.120/oauth/?request_token
 - Authentication Token URI: http://192.168.100.120/login.php
 - Access Token URI: http://192.168.100.120/?access_token 
   
因此，按照具体的部署环境，更改client目录下的config.php；
Provider端需要首先通过sql/schema.sql建立相应的库表，并配置class/Db.class.php。
然后通过访问client的首页，例如http://192.168.100.100/client/即可开始测试。

如果在测试过程中发现问题，请注意分析两个web服务器的日志信息，以帮助定位。


### 代码说明

下面按照代码的目录和文件结构进行简单说明

- class 针对interfaces目录下的接口的具体实现
  - Consumer.class.php 
     - Consumer/Client的操作实现，
    含Consumer的创建，状态设置/查询，单次值处理等，
    通过Db.class.php实现存储和查询。
  - Db.class.php
     - OAuth相关的consumer、token信息的数据库操作。在新环境试验该原型，需要修改相应的数据库参数。
  - Provider.class.php
     - 实现自定义的Provider的关键，主要是要实现PHP oauth库中要求至少实现的三个handler方法，见本文件
    中的构造方法和注释。
  - Token.class.php 
     - 令牌的操作实现。
  - User.class.php  
     - 自定义API的一个示例，这里实现了获取用户基本信息的方法。依此类推，还可以实现自身平台的特殊数据服务。
- client
  - apicall.php
  - callback.php
  - config.php
  - getgpa.php
  - getuid.php
  - index.php
- favicon.ico
- interfaces
  - IConsumer.php
  - IToken.php
  - IUser.php
- oauth
  - index.php
  - login.php
- README.md
- sql
  - schema.sql


