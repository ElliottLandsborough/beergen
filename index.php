<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>BeerGen</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
		<h1>BeerGen</h1>
		<p>Get a legit barcode emailed to your inbox <a href="https://www.brewdog.com/1million" target="_blank">here</a>.</p>
		<p>Please enter a number netween 10 and 99999 for 'end'.</p>
		<p>I will iterate downwards from it 20 times.</p>
		<p>From comparison of a few barcodes it looks like they all start with '5383' and end with the total number of codes that have been given away.</p>
		<p>The middle is padded with '0' until the length is 14 characters.</p>
		<p>This may all change in the future?</p>
		<p>example 1: 53830000008700 <-- not far off my legit one</p>
		<p>example 2: 53830000099999 <-- i guessed this one</p>
<?php

require_once 'vendor/autoload.php';

$front = isset($_GET['front']) ? $_GET['front'] : false;
$end = isset($_GET['end']) ? $_GET['end'] : false;
$end = (intval($end) >= 10) ? $end : '10';

if ($front && $end) {
    $charCount = 14;

    $barcodes = [];

    $endInt = intval($end);

    for ($i = $endInt; $i >= ($endInt - 10); $i--) {
        $zeroPadCount = $charCount - strlen($i);
        $frontPadded = str_pad($front, $zeroPadCount, "0");
        $barCode = $frontPadded . $i;
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $barcodes[$barCode] = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barCode, $generator::TYPE_CODE_128, 2.5, 100)) . '">';
        $generated = true;
    }
}

?>
        <form method="get">
            <p>
                Front: 
                <input type="text" name="front" value="<?php echo isset($_GET['front']) ? intval($_GET['front']) : '5383'; ?>" />
            </p>
            <p>
                End: 
                <input type="text" name="end" placeholder="99999" value="<?php echo isset($_GET['end']) ? intval($end) : '8700' ?>" />
            </p>
            <p>
                <input type="submit" style="height:48px;width:75px;" />
            </p>
        </form>

<?php if (isset($generated)) : ?>

        <style>
        img {display: block; margin: 0 auto;}
        .text {color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:21px;font-weight:bold;line-height:18px;letter-spacing:0.7px;text-align:center}
        </style>
<?php

foreach ($barcodes as $c => $bc) {
    echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
    echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';

    echo $bc;

    echo '<p class="text">' . $c . '</p>';

    echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
    echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
}
endif; ?>
    <p><a target="_blank" href="https://github.com/ElliottLandsborough/beergen">View on github...</a></p>
    </body>
</html>