# Extract text from pdf or separat a single pdf files to multiple files


This package provides a class to extract text from a pdf.

```php
use Escarter\PopplerPhp\PdfToText;
use Escarter\PopplerPhp\getOutput;

echo PdfToText::getText('document.pdf'); //returns the text from the pdf
echo PdfToText::getOutput('document.pdf','destination_path/page_%d.pdf'); //returns null
```


## Requirements

Behind the scenes this package leverages [pdftotext](https://en.wikipedia.org/wiki/Pdftotext) and  [pdfseparate](https://en.wikipedia.org/wiki/Pdfseparate).You can verify if the binary installed on your system by issueing this command:

```bash
which pdftotext
```
```bash
which which pdfseparate
```

If they are installed the above commands will return the path to the binary.

To install the binary you can use this command on Ubuntu or Debian:

```bash
apt-get install poppler-utils
```

On a mac you can install the binary using brew

```bash
brew install poppler
```

If you're on RedHat or CentOS use this:

```bash
yum install poppler-utils
```

## Installation

You can install the package via composer:

```bash
composer require escarter/proppler-php
```

## Usage Extracting text

Extracting text from a pdf is easy.

```php
$text = (new PdfToText())
    ->setPdf('document.pdf')
    ->text();
```

Or easier:

```php
echo PdfToText::getText('document.pdf');
```

By default the package will assume that the `pdftotext` command is located at `/usr/bin/pdftotext`.
If it is located elsewhere pass its binary path to constructor

```php
$text = (new PdfToText('/custom/path/to/pdftotext'))
    ->setPdf('document.pdf')
    ->text();
```

or as the second parameter to the `getText` static method:

```php
echo PdfToText::getText('document.pdf', '/custom/path/to/pdftotext');
```

Sometimes you may want to use [pdftotext options](https://linux.die.net/man/1/pdftotext). To do so you can set them up using the `setOptions` method.

```php
$text = (new PdfToText())
    ->setPdf('table.pdf')
    ->setOptions(['layout', 'r 96'])
    ->text()
;
```

or as the third parameter to the `getText` static method:

```php
echo PdfToText::getText('document.pdf', null, ['layout', 'opw myP1$$Word']);
```

Please note that successive calls to `setOptions()` will overwrite options passed in during previous calls. 

If you need to make multiple calls to add options (for example if you need to pass in default options when creating 
the `Pdf` object from a container, and then add context-specific options elsewhere), you can use the `addOptions()` method:
 
 ```php
 $text = (new PdfToText())
     ->setPdf('table.pdf')
     ->setOptions(['layout', 'r 96'])
     ->addOptions(['f 1'])
     ->text()
 ;
 ```

## Usage Separating Pdf into single files for each page

Separating a single pdf file into multiple files for each page.

```php
 (new PdfSeparate())
    ->setPdf('document.pdf')
    ->setDestination('destination_path/page_%d.pdf')
    ->split();
```
Or easier:

```php
 PdfSeparate::getOutput('document.pdf','destination_path/page_%d.pdf');
```

Once this is executed you can check in the destination_path to see all the splitted files (page_1.pdf, page_2.pdf....)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Testing

```bash
 composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mbutuhescarter@gmail.com instead of using the issue tracker.

## Credits

- [Escarter Mbutuh](https://github.com/escarter)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.