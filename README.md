# LQD Defaultweb 3.0
Nové jádro LQD webů a zakázkových systémů

## Požadavky
PHP >=7.1 a Mysql >=5.5.0
- **nette 2.4.***
*(běžíme na Nette frameworku)*

## Coding standard

https://github.com/liquiddesign/codestyle

## Rozšíření
- **lqdlib/security**
*(autorizátor, autentizátor, definice modelů účtů, rolí a práv)*
- **lqdlib/pages**
*(pěkné url a zjednodušení vytváření landing pages, definice modelů stránek)*
- **lqdlib/translation**
*(statické překlady, definice modelů překladů)*
- **lqdlib/cms**
*(formulář, datalist, datatable, paginator a podobně)*
- **lqdlib/storm**
*(databázový framework)*
- **lqdlib/admin**
*(administrační kostra, autorizátor, definice modelů, rozšíření cms)*
- **lqdlib/modules**
*(kolekce tříd pro rozšíření modulů, nutné pro instalaci modulů)*
### Moduly
- **lqdmod/web**
*(menu, články a základní zobrazení obsahu)*
- **lqdmod/eshop**
*(základní eshop)*

## Instalace
composer create-project liquiddesign/defaultweb3 muj-projekt

DEV verze -  composer create-project -s dev liquiddesign/defaultweb3 muj-projekt

## Použití

1. [Adresáře](#parameters)

### 1. Adresáře<a id="parameters"></a>
- appDir
- wwwDir (baseDir)
- tempDir
- logDir
- pubDir
- baseDir