# LQD Defaultweb 3.0
Nové jádro LQD webů a zakázkových systémů

## Požadavky
PHP >=7.1 a Mysql >=5.5.0
- **nette 2.4.***
*(běžíme na Nette frameworku)*

### Rozšíření
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

Další adresáře:

Relativní cesty

### 2. Jazykové nastavení<a id="languages"></a>

### 3. Cache a timestamp<a id="cahce"></a>

### 4. Scripty<a id="scripts"></a>

- **composer clear-nette-cache**
*(vyčistí cache)*
- **composer installer**
*(spustí instalátor)*
- **composer sync-pages**
*(synchronizuje stránky konfigu s databázi)*
- **composer sync-database**
*(synchronizuje strukturu databáze s modelama)*
- **composer maintance on|off**
*(zapne maintanence mode)*

Alternativně možnost volat skrze prohlížeč v debug módu: scripts/clear-cache, scripts/sync-database

## Coding standard
Coding standart je Nette standart tedy PSR2 s tabulátory jako odsazení.

Návod na istalaci Code Sniffer do PhpStorm IDE:
https://confluence.jetbrains.com/display/PhpStorm/PHP+Code+Sniffer+in+PhpStorm

```xml
<?xml version="1.0"?>
<ruleset name="MyStandard">
    <description>PSR2 with tabs instead of spaces.</description>
    <arg name="tab-width" value="4"/>
    <rule ref="PSR2">
        <exclude name="Generic.WhiteSpace.DisallowTabIndent"/>
    </rule>
    <rule ref="Generic.WhiteSpace.DisallowSpaceIndent"/>
    <rule ref="Generic.WhiteSpace.ScopeIndent">
        <properties>
            <property name="indent" value="4"/>
            <property name="tabIndent" value="true"/>
        </properties>
    </rule>
    <rule ref="Generic.Files.LineLength">
        <properties>
            <property name="lineLimit" value="160"/>
            <property name="absoluteLineLimit" value="160"/>
        </properties>
     </rule>
</ruleset>
``` 

### Struktura adresářů a pojmenování souborů
- custom
    - data
    - examples
    - src
        - Forms
        - Controls
        - assets (css, js)
        - Bridges
            - CustomDI (extensions)
            - CustomTracy (debug panel)
        - templates
        - DB (model, repository, interface)
        - Controls (komponenty / Product.php)
        - ProductException.php
        - IProduct.php
        - ProductFactory.php
        - config.neon
        - composer.json

### Další info a rozšíření standartu

#### Psání v angličtině a češtině

#### Proměnné

#### Nastavení IDE

#### Verzování a nasazování
- zdrojový kód v EN, včetně komentářů
- README.md a návody v CZ
- dodržování jednotných čísel tříd, metod, proměnných, kde to má smysl
- dodržování navratových typu a jejich definice dle PHP 7
- tagování verzí ve tvaru "v1.0.0"
- dodržovat adresářovou strikturu (presenters, views, models, forms, controls)
- dodržování názvosloví tříd a souborů dle PSR4, vypnutý robotloader!
- v PhpStormu nastavit "Nette Code style" dle https://nette.org/en/coding-standard
- dodržování "Nette Code style" konvence a dodržovat je, tedy PSR2 s tabulátory
- u třídových repozitářu používat "merge request"
- Reference na třídy jako MyClass::class ne jako string
- Pojmenovani služeb repozitaru: repository.security.account

## TODO
- NPM install a smazat css a js slozky
- novinky vyresit, slider vyresit, logomap (partneri) web - doplnit z Novalje zakladem...
- trusted_ips ktery by se detekoval z ip /napriklad spousteni cronu a podobne
- STORM - metody add sync a podobne maji jako vstupni parametr objekt typu, coz neni univerzalni v ramci naseho modulovaho systemu kdyz repozitar je dynamicky / 
- COMMON pridat tam model trait Path a repozitory trait Path pro stromove zobrazeni 
- FIX installer: pridava jazyky namisto aby je prepisoval Neon::encode($value, BEZ PARAMETRU U LANGUAGES); 
- dopsat readme a dat ruleset.xml do example, kam dat jak co se dela, + jak se co dela v 
phpstormu
- pridat dat marovy css styly
- script na vlozeni dat (nejlip json typ s referencama @layout.latte)
- proces kdyz programator prijde do projektu
- defaultne web, v adresa app, vyber homepage pri instalaci
- fronend editing text
- custom definice jazyku -> misto v hlavnim
- veci do templatu a dalsi veci do presenteru jako dekoratorz
https://doc.nette.org/cs/2.4/di-builtin-extensions
- Opravit dědení z modelů