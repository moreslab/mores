<?php
//metinDuzenleme() fonksiyonunu kullanarak birden fazla boşlukları temizleyebilir, cümlelerin ilk harflerinin büyük yazılmasını sağlayabilirsiniz.

function metinDuzenleme($metin) { 
    $cumleler      = preg_split('/([.?!]+)/', $metin, -1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
    $dizi       = ''; 
    foreach ($cumleler as $anahtar => $cumle) { 
        $dizi  .= ($anahtar & 1) == 0? 
            ucfirst(strtolower(trim($cumle))) : 
            $cumle.' '; 
    } 
    return trim($dizi); 
}

$metin = 'bu bir cümledir.    cümlenin    sonunda nokta varsa büyük başlar. sahiden mi? bilmem.';
echo metinDuzenleme($metin);

?>
