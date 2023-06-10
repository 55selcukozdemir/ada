<?php

/*

Vagonların nasıl rezerve edileceğini hesaplar.

Vagon listesi baştan sona gezilirken, ilk vagondan itibaren tam doldurularak yazılır.
Örneğin 3 vagon olsun, 
2   3  6    bunlar her vagon için boş koltuklar olsun.
🚂🚋 🚋 🚋

Eğer; toplamda 3 kişi yerleşecekse vagonların doluluk oranı aşağıda ki gibi olur.
    2  1  0    her vagon için son etapta dolulukları.
🚂🚋 🚋 🚋

Son olarak bize dönecek liste 
    2  1
🚂🚋 🚋
                
*/
function vagonKapasiteHesapla($data)
{
    $trenler = $data['Tren'];
    $trenVagonlari = $trenler['Vagonlar'];

    $rezervasyonYapilacakKisiSayisi = $data['RezervasyonYapilacakKisiSayisi'];
    $kisilerFarkliVagonaYerlestirilebilir = $data['KisilerFarkliVagonlaraYerlestirilebilir'];

    # Vagonların limitlerini hesaplayalım.

    $vagonlarKapasite = vagonToplamKapasiteyiVer($trenVagonlari);

    # kişileri kapasiteye göre test edelim.

    if ($kisilerFarkliVagonaYerlestirilebilir) {
        #toplam kapasiteyi bulup kontrol sağlanır. 
        #vagon yerleşimi en baştaki vagondan başlanır ve doldurularak ilerler.
        $toplamKapasite = 0;
        foreach ($vagonlarKapasite as $vagon) {
            $toplamKapasite += $vagon["Kapasite"];
        }

        if ($toplamKapasite >= $rezervasyonYapilacakKisiSayisi) {

            $rezervasyon = $rezervasyonYapilacakKisiSayisi;
            $yerlestirilecekVagonlar = [];
            foreach ($vagonlarKapasite as $vagon) {

                $herVagonKapasite = 0;

                if ($rezervasyon >= $vagon["Kapasite"]) {
                    $herVagonKapasite = $vagon["Kapasite"];
                    $rezervasyon -= $vagon["Kapasite"];
                } elseif ($rezervasyon > 0) {
                    $herVagonKapasite = $rezervasyon;
                    $rezervasyon = 0;
                } else {
                    $rezervasyon = 0;
                    break;
                }



                // aşağıda vagonların her birini kontrol ediyoruz ve içine hiç  yolcu yerleşmeyen vagonları 
                // sonuç listesine dahil etmiyoruz.
                if ($herVagonKapasite != 0) {
                    array_push(
                        $yerlestirilecekVagonlar,
                        array(
                            "Ad" => $vagon["Ad"],
                            "Kapasite" => $herVagonKapasite
                        )
                    );
                }
            }

            return array(
                "RezervasyonYapilabilir" => true,
                "YerlesimAyrinti" => $yerlestirilecekVagonlar
            );
        } else {
            return array(
                "RezervasyonYapilabilir" => false,
                "YerlesimAyrinti" => []
            );
        }
    }

    // Aynı vagona yerleşemek isteyenler buraya girer
    else {
        foreach ($vagonlarKapasite as $vagon) {
            if ($vagon["Kapasite"] >= $rezervasyonYapilacakKisiSayisi) {
                return array(
                    "RezervasyonYapilabilir" => true,
                    "YerlesimAyrinti" => array(
                        "VagonAdi" => $vagon["Ad"],
                        "KisiSayisi" => $rezervasyonYapilacakKisiSayisi
                    )
                );
            } else {
                return array(
                    "RezervasyonYapilabilir" => false,
                    "YerlesimAyrinti" => array(
                        "VagonAdi" => []
                    )
                );
            }
        }
    }

}



/*

Tüm vagonların kapasitelerini tek tek toplar ve döner.

*/
function vagonToplamKapasiteyiVer($trenVagonlari)
{
    $vagonlarKapasite = [];
    foreach ($trenVagonlari as $vagon) {

        if (floor($vagon["Kapasite"] * 0.7) > $vagon["DoluKoltukAdet"]) {
            $bosKoltukSayisi = floor($vagon["Kapasite"] * 0.7) - $vagon["DoluKoltukAdet"];
        } else {
            $bosKoltukSayisi = 0;
        }
        array_push(
            $vagonlarKapasite,
            array(
                "Ad" => $vagon["Ad"],
                "Kapasite" => $bosKoltukSayisi
            )
        );
    }

    return $vagonlarKapasite;
}

?>