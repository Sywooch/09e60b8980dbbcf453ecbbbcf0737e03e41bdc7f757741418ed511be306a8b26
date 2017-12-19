<style>
    code{
        color: red;
        font-size: 18px;
    }
    help{
        color: #2E7D32;
        font-size: 13px;
    }
    orinak{
        color: blue;
    }
</style>
<h2>Города</h2>
<code>City</code><br>
<h3>---.getList <help>GET x;y (cordinat client)</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/City.getList?x=55&y=9</orinak><br>
<orinak>https://city.ooogoroda.mobi/City.getList?x=55&y=9 (glxavor domain)</orinak><br> 

<h2>Афиши</h2>
<code>Poster</code><br>
<h3>---.getList <help>GET filtr(id filtri)</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Poster.getList</orinak><br>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Poster.getList?category_id=3</orinak><br>
<h3>---.get <help>GET ID </help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Poster.get?id=2</orinak><br>

<h2>User</h2>
<code>User</code><br>
<h3>---.reg <help>POST</help></h3>
<help>method={email,..,..} (tvjal pahin menak gortum a registracia formajov)</help>
<ul>
    <h4>METHOD::EMAIL</h4>
    <span>anpajman poxancvox parametrnern en</span>
    <li>email=(pochtaji hascen)</li> 
    <li>pass=(gaxtnabary min 6)</li>
    <li>name=(anuny)</li>
    <li>f_name=(azganuny)</li>
    <li>method=email*</li>
    <li>inchpes najev karox e kcvel foton </li>
</ul>
* methodov nkaragrvum a reg linelu dzevy partadir pajman a registraciaji tvjalneri het uxarkely<br>
hajoxutjan depqum "response":"OK"
<br>
<orinak>--POST "method=email&email=test@mail.ru&pass=123456789&name=a&f_name=b" https://api-ramenskoye.ooogoroda.mobi/User.reg</orinak><br>
<br>
<h3>---.login <help>POST</help></h3>
<help>method={email,..,..} (tvjal pahin menak gortum a email ov loginy)</help>
<ul>
    <h4>METHOD::EMAIL</h4>
    <span>anpajman poxancvox parametrnern en</span>
    <li>email=(pochtaji hascen)</li> 
    <li>pass=(gaxtnabary min 6)</li>
    <li>method=email*</li>
</ul>
* methodov nkaragrvum a login linelu dzevy partadir pajman a login i hamar<br>
hajoxutjan depqum "response":{"token":"dbe5ca45830f972504c48982fa3d314f"} (tokeny vory arden piti zaprosneri zamanak header um lini "x-access-token")<br>
inchpes najev veradarcnum a <br>
['name']<br>
['f_name']<br>
['photo_250']<br>
<br>
<orinak>--POST "method=email&email=test@mail.ru&pass=123456789" https://api-ramenskoye.ooogoroda.mobi/User.login</orinak><br>

<h3>---.accessToken <help>POST</help></h3>
<help>"response":"OK" nshanakum a der access tokeny irakan a</help>
<orinak>https://api-ramenskoye.ooogoroda.mobi/User.accessToken</orinak><br>

<h3>---.update <help>POST</help></h3>
<help>"response":"OK" nshanakum a update katarvel a</help><br>
<orinak>https://api-ramenskoye.ooogoroda.mobi/User.update</orinak><br>
<ul>
    <span>anpajman poxancvox parametrnern en</span>
    <li>name=(anun)</li> 
    <li>f_name=(azganun)</li>
</ul>

<h2>HOME</h2>
<code>Home</code><br>
<h3>---.get </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Home.get</orinak><br>

<h2>News</h2>
<code>News</code><br>
<h3>---.getCat <help></help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/News.getCat</orinak>(stanum a burgeri meji catigorianeri hamar)<br>

<h3>---.getList </h3>
<help>GET cat_id (stanum a es depqum burgeri mej avelacvac categoriaji 'id' -in)</help>
<orinak>https://api-ramenskoye.ooogoroda.mobi/News.getList</orinak> (iskakan News -y)<br>
<orinak>https://api-ramenskoye.ooogoroda.mobi/News.getList?cat_id=2</orinak> (stanum a burgeri meji 2 ID unecoxi hamar)<br>

<h3>---.get<help></help> (stanuma konkret news i item -y)</h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/News.get</orinak><br>
<ul>
    <span>vorpes paramets karox e poxancvel GET ev POST</span>
    <li>GET id <orinak>https://api-ramenskoye.ooogoroda.mobi/News.get?id=4</orinak>(stanum a 4 hamari Id -ov news i item)</li> 
<li>GET id ev POST 'comment' <orinak>https://api-ramenskoye.ooogoroda.mobi/News.get?id=4</orinak>(comment a anum news -i tak ev stanum a 4 hamari Id -ov news)</li>
<li>GET id , GET 'comment_id' ev POST 'comment' <orinak>https://api-ramenskoye.ooogoroda.mobi/News.get?id=4&comment_id=14</orinak>(UPDATE a anum comment 14 -y ev stanum a 4 hamari Id -ov news)</li>
</ul>

<h2>Communication</h2>
<code>Communication</code><br>
<h3>---.getList </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Communication.getList</orinak><br>
<br>
<h3>---.get </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Communication.get?id=3</orinak><br>
stanum a konkret post yst nran poxancvox id ov <code>$GET[id]</code>
commentnery ashxatum en nuj devi inch vor news um <br>

<br>
<<----(poxarinvac mas 29.10.2017)
<h3>---.post<help></help> </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Communication.post</orinak><br>
post es avelacnum uxarkelov miajn <code>$POST[post]</code>
aranc get parametri avelacnum a Posty
------>
<br>
isk posti popoxutjuny zaprosin avelacvum a post i id in <code>$GET[id]</code> 
<orinak>https://api-ramenskoye.ooogoroda.mobi/Communication.post?id=2</orinak><br>
chenq moranum posti parnakutjuny <code>$POST[post]</code> um
<ul>
    comenty nujn a vonc vor news um .
</ul>

<h2>Organizations</h2>
<code>Organizations</code><br>
<h3>---.getList <help></help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Organizations.getList</orinak>(stanum a 3 tesaki respoinse :kara stana category_list KAM (OR) item_list: u reklam , ete et ejum linelu a uremn liqy ete che datark. hima drac a vor misht cuc ta)<br>

<h3>---.getList </h3>
<help>GET cat_id (stanum a categorai meji parnakutjuny , nujn a inch vor hasarak depqum)</help>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Organizations.getList?cat_id=2</orinak> (stanum a 2 ID unecoxi categoriaji meji parnakutjuny)<br>

<h3>---.get<help></help> (stanuma konkret item -y)</h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Organizations.get</orinak>(aranc id i chi ashxatum)<br>
<ul>
    <span>vorpes paramets karox e poxancvel GET ev POST</span>
    <li>GET id <orinak>https://api-ramenskoye.ooogoroda.mobi/Organizations.get?id=4</orinak>(stanum a 4 hamari Id -ov  item)</li> 
<li>GET id ev POST 'comment' <orinak>https://api-ramenskoye.ooogoroda.mobi/Organizations.get?id=4</orinak>(comment a anum item -i tak ev stanum a 4 hamari Id -ov item)</li>
<li>GET id , GET 'comment_id' ev POST 'comment' <orinak>https://api-ramenskoye.ooogoroda.mobi/Organizations.get?id=4&comment_id=14</orinak>(UPDATE a anum comment 14 -y ev stanum a 4 hamari Id -ov itemy)</li>
</ul>



<h2>Объявления</h2>
<code>Ads</code><br>
<h3>---.getList <help></help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.getList</orinak>(stanum a 3 tesaki respoinse :kara stana category_list KAM (OR) item_list: u reklam , ete et ejum linelu a uremn liqy ete che datark. hima drac a vor misht cuc ta)<br>

<h3>---.getList </h3>
<help>GET cat_id (stanum a categorai meji parnakutjuny , nujn a inch vor hasarak depqum)</help>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.getList?cat_id=2</orinak> (stanum a 2 ID unecoxi categoriaji meji parnakutjuny)<br>

<h3>---.get </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.get?id=3</orinak><br>
stanum a konkret post yst nran poxancvox id ov <code>$GET[id]</code>
commentnery ashxatum en nuj devi inch vor news um <br>
<h3>---.hide </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.hide?id=3</orinak><br>
taqcum a konkret der grac id <code>$GET[id]</code>

<br>

<h3>---.post<help></help> </h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.post</orinak><br>
post es avelacnum uxarkelov  <code>$POST[post]</code> ev <code>$POST[cat_id]</code>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.post?cat_id=5 </orinak><br>
aranc cat_id xndrum em chavelacnel :)
<br>
isk posti popoxutjuny zaprosin avelacvum a post i id in <code>$GET[id]</code> 
<orinak>https://api-ramenskoye.ooogoroda.mobi/Ads.post?id=2</orinak><br>
u <code>$POST[post]</code> i parnakutjuny
<ul>
    comenty nujn a vonc vor news um .
</ul>

<br>
<h2>Реклама</h2>
<code>Advertising</code><br>
<h3>---.get <help></help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Advertising.get</orinak>
Reklami formi hamar uxarkum eq POST zapros hetevjal anunerov<br>
<b>name</b><br>
<b>tel</b><br>
<b>email</b><br>
ete amin inch normal a ancnum veradarcnum a 'OK'

<br>
<h2>Favorite</h2>
<code>Favorite</code><br>
<h3>--- <help>.getList</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Favorite.getList</orinak>
stanum a useri favoritnery<br>
<h3>--- <help>.post</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Favorite.post</orinak>
<br><code>$POST[id]</code> uxarkum a organizacaji ID vory petq a pahel bazzajum hetaga get anelu hamar
<h3>---<help>.delete</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Favorite.delete</orinak>
<br><code>$POST[id]</code> uxarkum a organizacaji ID vory petq a heracnel bazajuc

<h2>Help</h2>
<code>Help</code><br>
<h3>--- <help>.get</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Help.get</orinak>

<h2>Search</h2>
<code>Search</code><br>
<h3>--- <help>.get</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Search.get?News</orinak>
<br><code>$POST[keyword]</code> (minimumy 2 nish) GET ov poxancvum a konktet modelneri tesaky vortex katarvum a pojisk . 
<br>kara lini case 'News':'Organizations':'Shares':'Poster':<br>
<h3>--- <help>.getList</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Search.getList</orinak>
<br><code>$POST[keyword]</code> (minimumy 2 nish) , Home page i hamar a naxatesvac


<h2>Shares</h2>
<code>Shares</code><br>
<h3>--- <help>.get</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Shares.get?id=3</orinak>
<h3>--- <help>.getList</help></h3>
<orinak>https://api-ramenskoye.ooogoroda.mobi/Shares.getList</orinak>
<br>ashxatum a nujn devi vonc vor  Poster -y<br>
