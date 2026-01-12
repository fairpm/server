The YoastSEO premium token can be found as the Secret `YOAST_SEO_PRO_TOKEN`

Composer is a tool used by many developers to install and update plugins.

Through MyYoast you can use Composer to get easy access to your premium plugins.Follow the instructions below to get started!

You can register your token with composer by running the command below:

`composer config -g http-basic.my.yoast.com token [TOKEN]`

You can then add our secure repository by running the following command:

`composer config repositories.my-yoast composer https://my.yoast.com/packages/`

Now you can install Yoast SEO Premium by running:

`composer require yoast/wordpress-seo-premium`

