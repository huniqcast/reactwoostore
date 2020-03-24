<img src="./logo.svg" width="250px" />

# WPGraphQL WooCommerce (WooGraphQL)

<a href="https://woographql.axistaylor.com/" target="_blank">Docs</a> • <a href="https://www.axistaylor.com" target="_blank">AxisTaylor</a> • <a href="https://wpgql-slack.herokuapp.com/" target="_blank">Join Slack</a>

[![Actions Status](https://github.com/wp-graphql/wp-graphql-woocommerce/workflows/Testing%20Integration/badge.svg)](https://github.com/wp-graphql/wp-graphql-woocommerce/actions?query=workflow%3A%22Testing+Integration%22) [![Actions Status](https://github.com/wp-graphql/wp-graphql-woocommerce/workflows/WordPress%20Coding%20Standards/badge.svg)](https://github.com/wp-graphql/wp-graphql-woocommerce/actions?query=workflow%3A%22WordPress+Coding+Standards%22) [![Coverage Status](https://coveralls.io/repos/github/wp-graphql/wp-graphql-woocommerce/badge.svg?branch=develop)](https://coveralls.io/github/wp-graphql/wp-graphql-woocommerce?branch=develop) 

## Quick Install
1. Install & activate [WooCommerce](https://woocommerce.com/)
2. Install & activate [WPGraphQL](https://www.wpgraphql.com/)
3. Clone or download the zip of this repository into your WordPress plugin directory & activate the **WP GraphQL WooCommerce** plugin.
4. (Optional) Install & activate [WPGraphQL-JWT-Authentication](https://github.com/wp-graphql/wp-graphql-jwt-authentication) to add a `login` mutation that returns a JSON Web Token.
5. (Optional) Install & activate [WPGraphQL-CORS](https://github.com/funkhaus/wp-graphql-cors) to add an extra layer of security using HTTP CORS and some of WPGraphQL advanced functionality. 

## What does this plugin do?
It adds WooCommerce functionality to the WPGraphQL schema using WooCommerce's [CRUD](https://github.com/woocommerce/woocommerce/wiki/CRUD-Objects-in-3.0) objects.

## Features
- Query **product**, **product variations**, **customers**, **coupons**, **orders**, **refunds** and **more** with complex filtering options.
- Manipulate customer session data using customer and cart mutations while managing customer session token using HTTP headers or cookies *(not recommended)*. *[HTTP header example w/ React/Apollo](https://github.com/wp-graphql/wp-graphql-woocommerce/pull/88)*
- Create orders using the `order` mutations with the `checkout` mutation.

## Future Features
- Payment Processing
- Adminstrator mutations. Eg. Creating and deleting products, coupons, and refunds.

## Playground
Feel free to test out the extension using the [playground](https://docs.wpgraphql.com/extensions/wpgraphql-woocommerce/). The playground allows you to execute queries and mutations, as well as view the schema.

## Wanna help support WooGraphQL's future.
- Sponsor **@kidunot89** *(WooGraphQL Creator/Developer)* on **[Github](https://github.com/sponsors/kidunot89)**
- Sponsor **WooGraphQL** on **[OpenCollective](https://opencollective.com/woographql)**
- Sponsor **WPGraphQL** on **[OpenCollective](http://opencollective.com/wp-graphql)**
- Sponsor **GraphQL-PHP** on **[OpenCollective](https://opencollective.com/webonyx-graphql-php)**
- Or **[Contribute](./CONTRIBUTING.md)**

## Follow [![alt text](http://i.imgur.com/tXSoThF.png)](https://twitter.com/woographql)[![alt text](http://i.imgur.com/P3YfQoD.png)](https://www.facebook.com/woographql)
