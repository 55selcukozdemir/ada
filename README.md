# Ada soru

https://selcukozdemir.space/ada/api.php

Yukarıda ki adrese post ederek kullanabilirsiniz.

## POST request

```
{
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
    "RezervasyonYapilacakKisiSayisi":3,
    "KisilerFarkliVagonlaraYerlestirilebilir":true
}
```

## POST response

```
{
    "RezervasyonYapilabilir":true,
    "YerlesimAyrinti":[
        {"VagonAdi":"Vagon 1","KisiSayisi":2},
        {"VagonAdi":"Vagon 2","KisiSayisi":1}
    ]
}
```

veya 
```
{
    "RezervasyonYapilabilir":true,
    "YerlesimAyrinti":[    ]
}
```

şeklinde cevap verir.
