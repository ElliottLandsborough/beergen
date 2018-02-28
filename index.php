<h1>BeerGen</h1>
<p>Please enter a number netween 10 and 99999 for 'end'.</p>
<p>I will iterate donwards from it 20 times.</p>
<p>example 1: 53830000008700</p>
<p>example 2: 53830000099999</p>
<?php

require_once 'vendor/autoload.php';

$front = isset($_GET['front']) ? $_GET['front'] : false;
$end = isset($_GET['end']) ? $_GET['end'] : false;

if ($front && $end) {
    $charCount = 14;

    $barcodes = [];

    $endInt = intval($end);

    for ($i = $endInt; $i >= ($endInt - 20); $i--) {
        $end = $i;
        $zeroPadCount = $charCount - strlen($end);
        $frontPadded = str_pad($front, $zeroPadCount, "0");
        $barCode = $frontPadded . $end;

        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        //echo $generator->getBarcode($barCode, $generator::TYPE_CODE_128);

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
        <input type="text" name="end" placeholder="99999" value="<?php echo isset($_GET['end']) ? intval($_GET['end']) : null ?>" />
    </p>
    <p>
        <input type="submit" />
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