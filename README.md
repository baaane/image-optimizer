# image-uploader

This package can create three different size of optimized images (Thumbnail-Mobile-Desktop). Here's how you can use it:

```php
use Baaane\ImageUploader\ImageUploadGenerator;

$path = __DIR__ .'/storage/'; //optional

$imageUploader = new ImageUploadGenerator($path);

$imageUploader->upload($_FILES[<filename>]);
```

# Installation
You can install the package via github or composer

```php
git clone https://github.com/baaane/image-uploader.git

composer require baaaaane/image-uploader
```
### Tools
The package required this library to optimize the image. 

- [image-optimizer](https://github.com/spatie/image-optimizer)

Here's how to install via compose:
```php
composer require spatie/image-optimizer
```

# Instructions
The path at <new ImageUploadGenerator(path)> will overwritten the default path of uploaded file. So it is optional if you want to put your desired path. 
Pass the required data array inside the function upload(array).  If you want to customize the name of the uploaded images. 
Put the new name in [input=type name=new_name]. Convert string to array and merge it together with the [FILES]. It should look like this:

#### Sample expected input
```php
//before merge
$_FILES = [
    'filename' => [
        'name' => 'uploaded-image.jpg',
        'type' => 'image/jpeg',
        'size' => 542,
        'tmp_name' =>	__DIR__. '/_files/test.jpg',
        'error' => 0,
    ]
];

$_POST = [ 
    'new_name' => 'new_name1'
];

```

#### Sample output after merge
```php
// Single upload file
$_FILES = [
    'filename' => [
        'name' => 'uploaded-image.jpg',
        'type' => 'image/jpeg',
        'size' => 542,
        'tmp_name' =>	__DIR__. '/_files/test.jpg',
        'error' => 0,
        'new_name' => 'new_name1'
    ]
];

// multiple upload file
$_FILES = [
	'filename' => [
        'name' => [
        	0 => 'uploaded-image.jpg',
        	1 => 'uploaded-image1.jpg',
        ],
        'type' => [
        	0 => 'image/jpeg',
        	1 => 'image/jpeg',
        ],
        'size' => [
        	0 => 542,
        	1 => 542,
        ],
        'tmp_name' => [
        	0 => __DIR__. '/_files/test.jpg',
        	1 => __DIR__. '/_files/test1.jpg',
        ],
        'error' => [
        	0 => 0,
        	1 => 0,
       	],
       	'new_name' => [
       		0 => 'new_name1',
        	1 => 'new_name2',
       	]
    ]
];
```

#### Sample return final output
```php
// single upload file
Array 
(
  0 => Array (
    "thumbnail" => "/_files/thumbnail_new_name1.jpg"
    "mobile" => "/_files/mobile_new_name1.jpg"
    "desktop" => "/_files/desktop_new_name1.jpg"
  )
)

// multiple upload file
Array 
(
  0 => Array (
    "thumbnail" => "/_files/thumbnail_new_name1.jpg"
    "mobile" => "/_files/mobile_new_name1.jpg"
    "desktop" => "/_files/desktop_new_name1.jpg"
  )
  1 => Array (
    "thumbnail" => "/_files/thumbnail_new_name2.jpg"
    "mobile" => "/_files/mobile_new_name2.jpg"
    "desktop" => "/_files/desktop_new_name2.jpg"
  )
)
```
## Example conversions
Here are some real life example conversions done by this package.

### Original: 
##### JPEG 272KB
![Original](https://github.com/baaane/image-uploader/blob/master/storage/app/public/test.jpg?raw=true)

### Optimized and Converted to Desktop|Mobile|Thumbnail: 
##### Desktop 1920 x 1080 | JPEG | 218KB
![Optimized](https://github.com/baaane/image-uploader/blob/master/storage/app/public/desktop_new_name1.jpg?raw=true)

##### Mobile 690 x 960 | JPEG | 50KB
![Optimized](https://github.com/baaane/image-uploader/blob/master/storage/app/public/mobile_new_name1.jpg?raw=true)

##### Thumbnail 300x300 | JPEG | 14KB
![Optimized](https://github.com/baaane/image-uploader/blob/master/storage/app/public/thumbnail_new_name1.jpg?raw=true)

# Credits
- [Spatie](https://github.com/spatie)
This package has been inspired by [spatie/image-optimizer](https://github.com/spatie/image-optimizer)

# License
The MIT License (MIT). Please see [License File](https://github.com/baaane/image-uploader/blob/master/LICENSE) for more information.