# Image Uploader
This package can generate different size of optimized images (Thumbnail-Mobile-Desktop). Here's how you can use it:

```php
use Baaane\ImageUploader\Action\ImageUploader;

$imageUploader = new ImageUploader();

$imageUploader->upload($_FILES['filename']);
```

## Installation
You can install the package via github or composer

```php
git clone https://github.com/baaane/image-uploader.git

composer require baaaaane/image-uploader
```
## Tools
This package is required in this library to optimize the image:

- [image-optimizer](https://github.com/spatie/image-optimizer)

Here's how to install via composer:
```php
composer require spatie/image-optimizer
```

## Instructions
The filenames can be randomized or customized by the user.

#### Customizable Name (OPTIONAL)
```
$new_name = [
    'new_name' => 'new_name1'
];

```

#### Customizable Size (FORMAT: WIDTH, HEIGHT) (OPTIONAL)
```

$size = [
    'size' => $imageUploader->setThumbnailSize(width,height)
                            ->setMobileSize(width,height)
                            ->setDesktopSize(width,height)
                            ->get(), 
];

```

#### Parameter for upload should be an array. It should look like this:
```
[
    'name' => 'uploaded-image.jpg',
    'type' => 'image/jpeg',
    'size' => 542,
    'tmp_name' => __DIR__. '/_files/test.jpg',
    'error' => 0,
    'new_name' => 'new_name1',
    'new_size' => [
        'thumbnail' => [
            'width' => 200,
            'height' => 200
        ]
        'mobile' => [
            'width' => 691,
            'height' => 961
        ]
        'desktop' => [
            'width' => 1920,
            'height' => 1080
        ]
    ]
]
```

### Sample Single Upload
```php
// Before merge
$_FILES = [
    'filename' => [
        'name' => 'uploaded-image.jpg',
        'type' => 'image/jpeg',
        'size' => 542,
        'tmp_name' =>	__DIR__. '/_files/test.jpg',
        'error' => 0,
    ]
];

// OPTIONAL PARAMETER: If the input post is string, convert it to array
$new_name = [
	'new_name' => 'new_name1'
];

// OPTIONAL PARAMETER: If the input post is string, convert it to array
$new_size = [
    'new_size' => $imageUploader->setThumbnailSize(200,200)
                                ->setMobileSize(691,961)
                                ->setDesktopSize(1920,1080)
                                ->get(), 
];

// Then merge
$data = array_merge($_FILES['filename'], $new_name, $new_size);

// OPTIONAL PARAMETER: desired path of uploaded files
$path = __DIR__. '/_files';

$imageUploader = new ImageUploader($path);
$imageUploader->upload($data);
```

### Sample Multiple Upload
````
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
        ]
    ]
];

// OPTIONAL PARAMETER: If the input post is string, convert it to array
$new_name = [
    'new_name' => ['new_name1', 'new_name2']
];

// OPTIONAL PARAMETER: If the input post is string, convert it to array
$size = [ 
    'new_size' => [
        $imageUploader->setThumbnailSize(200,200)
                        ->setMobileSize(691,961)
                        ->setDesktopSize(800,750)
                        ->get(),
        $imageUploader->setThumbnailSize()
                        ->setMobileSize(345,789)
                        ->setDesktopSize(0,0)
                        ->get(),
    ]
];

// Then merge
$data_merge = array_merge($_FILES['filename'], $new_name, $new_size);

// Re-array the merge data
$data = $imageUploader->reArray($data_merge);

// OPTIONAL PARAMETER: desired path of uploaded files
$path = __DIR__. '/_files';

$imageUploader = new ImageUploader($path);
$imageUploader->upload($data);
````

#### For multiple uploads, use this line of code for re-arrange the array before passing the array to imageUploader->upload:
```
$data = $imageUploader->reArray($data_merge);
```
From:
```
[
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
    ],
    'new_size' => [
        0 => [
            'thumbnail' => [
                'width' => 200,
                'height' => 200
            ]
            'desktop' => [
                'width' => 800,
                'height' => 750
            ],
            'mobile' => [
                'width' => 345,
                'height' => 789
            ]
        ],
        1 => [
            'thumbnail' => [
                'width' => 0,
                'height' => 0
            ]
            'desktop' => [
                'width' => 0,
                'height' => 0
            ]
            'mobile' => [
                'width' => 345,
                'height' => 789
            ]
        ]
    ]
];
```
To:
```
[
  0 => [
    'name' => 'uploaded-image.jpg'
    'type' => 'image/jpeg'
    'size' => 542
    'tmp_name' => __DIR__. '/_files/test.jpg',
    'error' => 0
    'new_name' => 'new_name1'
    'new_size' => [
        'thumbnail' => [
            'width' => 200,
            'height' => 200
        ]
        'mobile' => [
            'width' => 691,
            'height' => 961
        ]
        'desktop' => [
            'width' => 1920,
            'height' => 1080
        ]
    ]
  ]
  1 => [
    'name' => 'uploaded-image1.jpg'
    'type' => 'image/jpeg'
    'size' => 542
    'tmp_name' => __DIR__. '/_files/test.jpg'
    'error' => 0
    'new_name' => 'new_name1'
    'new_size' => [
        'thumbnail' => [
            'width' => 200,
            'height' => 200
        ]
        'mobile' => [
            'width' => 691,
            'height' => 961
        ]
        'desktop' => [
            'width' => 1920,
            'height' => 1080
        ]
    ]
  ]
]
```

#### Sample retrieve files after uploading. Return an array upon success.
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
Here are the example conversions done by this package.

### Original: 
##### 1920 x 1080 | JPEG | 272KB
![Original](https://github.com/baaane/image-uploader/blob/master/storage/app/public/test.jpg?raw=true)

### Optimized and Converted to Desktop | Mobile | Thumbnail: 
##### Desktop 1920 x 1080 | JPEG | 218KB
![Optimized](https://github.com/baaane/image-uploader/blob/master/storage/app/public/desktop_new_name1.jpg?raw=true)

##### Mobile 690 x 960 | JPEG | 50KB
![Optimized](https://github.com/baaane/image-uploader/blob/master/storage/app/public/mobile_new_name1.jpg?raw=true)

##### Thumbnail 300x300 | JPEG | 14KB
![Optimized](https://github.com/baaane/image-uploader/blob/master/storage/app/public/thumbnail_new_name1.jpg?raw=true)

## Credits
- [Spatie](https://github.com/spatie)
This package has been inspired by [spatie/image-optimizer](https://github.com/spatie/image-optimizer)

## License
The MIT License (MIT). Please see [License File](https://github.com/baaane/image-uploader/blob/master/LICENSE) for more information.
