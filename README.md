# OAuth Provider Example

本项目来自[djpate/OAuthProviderExample](http://github.com/djpate/OAuthProviderExample)，
以PHP官方的oauth扩展包为基础，实现了一个
OAuth Provider **原型**(不能直接用于生产环境)。

除此以外，项目中还提供了一个简单的oauth客户端(
OAuth 1.0 RFC 5849 中称为Client/Consumer)的代码
示例。

### 参考资料

1. PHP oauth官方手册，可以获得Oauth与OAuthProvider
的API指南；
2. djpate的博客 [How to write a complete OAuth Provider in PHP5](http://djpate.com/2011/01/13/how-to-write-a-complete-oauth-provider-in-php5/)
3. [OAuth的官方网站](http://oauth.net)
4. OAuth RFC 5859 & 2.0 draft & mail list

### 代码说明
...php
.
├── class
│   ├── Consumer.class.php
│   ├── Db.class.php
│   ├── Provider.class.php
│   ├── Token.class.php
│   └── User.class.php
├── client
│   ├── apicall.php
│   ├── callback.php
│   ├── config.php
│   ├── getgpa.php
│   ├── getuid.php
│   └── index.php
├── favicon.ico
├── interfaces
│   ├── IConsumer.php
│   ├── IToken.php
│   └── IUser.php
├── oauth
│   ├── index.php
│   └── login.php
├── README.md
└── sql
    └── schema.sql
...


