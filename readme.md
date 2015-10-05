# Expires

Do you know when your domains and SSL certificates expire?

![Expiration dates of my domins](http://i.imgur.com/JovPreA.jpg)

## Usage

 * Install dependencies by running `composer install`.
 * Update the array of domains in the `./config.php` file.
 * Run the checks using the command below.

### Run Checks

The following command will check each domains whois expiration, and if applicable the certificate expiration.

```bash
php -f ./check.php
```

*Note: By default whois and certificate data is cached for 24 hours.*

## Notes

Downloading domain certificates uses the local `openssl s_client` command.

Reading the downloaded certificates also uses the `openssl_x509_parse` function which means PHP should be compiled with the `--with-openssl` flag.

Build by [Joel Vardy][joelvardy].

  [joelvardy]: https://joelvardy.com
