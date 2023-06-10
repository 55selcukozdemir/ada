<?php 
include "vagon.php";



$response = '{
    "Tren":
    {
        "Ad":"Başkent Ekspres",
        "Vagonlar":
        [
            {"Ad":"Vagon 1", "Kapasite":100, "DoluKoltukAdet":68},
            {"Ad":"Vagon 2", "Kapasite":90, "DoluKoltukAdet":50},
            {"Ad":"Vagon 3", "Kapasite":80, "DoluKoltukAdet":80}
        ]
    },
    "RezervasyonYapilacakKisiSayisi":25,
    "KisilerFarkliVagonlaraYerlestirilebilir":true
}
';

// $data = json_decode($response, true);







if($_SERVER["REQUEST_METHOD"] === "POST"){
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    print_r(json_encode(vagonKapasiteHesapla($data)));
} else {


}
    
?>