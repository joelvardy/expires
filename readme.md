# Expires

Will send you an email with a table showing each domain and when the domain / ssl certificate expires. It will also query the Google Safe Browsing API and return the status.

## Usage

 * Install dependencies by running `composer install`.
 * Update the details in the `./config.yml` file.
 * Run the checks using the command below.

### Run Checks

The following command will run the checks and send the results by email.

```bash
php -f ./check.php
```

*Note: By default results are cached for 12 hours.*

## Notes

Downloading domain certificates uses the local `openssl s_client` command.

Reading the downloaded certificates also uses the `openssl_x509_parse` function which means PHP should be compiled with the `--with-openssl` flag.

Built by [Joel Vardy][joelvardy].

  [joelvardy]: https://joelvardy.com
