#Image Extractor

This class extracts an image from a url.
supports open graph images, img tags and Youtube embed previews (in that order)

##Usage

```
<?php 

use Aboustayyef\ImageExtractor;

$imageExtractor = new ImageExtractor('http://url.goes/here');
$img = $imageExtractor->get(300); // Where 300 here is the minimum width accepted for an image

?>

```

##Disqalifying Image
```
<?php 

use Aboustayyef\ImageExtractor;

$imageExtractor = new ImageExtractor('http://url.goes/here');
$img->disqualify('http://image.to/disqualify.jpg');
$img = $imageExtractor->get(300); // resulting image will not include disqualified image

?>

```