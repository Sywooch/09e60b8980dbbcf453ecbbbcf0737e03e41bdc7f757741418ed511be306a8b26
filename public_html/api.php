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
<orinak>http://api.ramenskoye.100081.ooogoroda.mobi/City.getList?x=55&y=9</orinak><br>
<orinak>http://api.100081.ooogoroda.mobi/City.getList?x=55&y=9 (glxavor domain)</orinak><br> 

<h2>Афиши</h2>
<code>Poster</code><br>
<h3>---.getList <help>GET filtr(id filtri)</help></h3>
<orinak>http://api.ramenskoye.100081.ooogoroda.mobi/Poster.getList</orinak><br>
<orinak>http://api.ramenskoye.100081.ooogoroda.mobi/Poster.getList?category_id=3</orinak><br>
<h3>---.get <help>GET ID </help></h3>
<orinak>http://api.ramenskoye.100081.ooogoroda.mobi/Poster.get?id=2</orinak><br>

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
<orinak>--POST "method=email&email=test@mail.ru&pass=123456789&name=a&f_name=b" http://api.ramenskoye.100081.ooogoroda.mobi/User.reg</orinak><br>
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
<orinak>--POST "method=email&email=test@mail.ru&pass=123456789" http://api.ramenskoye.100081.ooogoroda.mobi/User.login</orinak><br>

<h3>---.accessToken <help>POST</help></h3>
<help>"response":"OK" nshanakum a der access tokeny irakan a</help>
<orinak>http://api.ramenskoye.100081.ooogoroda.mobi/User.accessToken</orinak><br>

<h3>---.update <help>POST</help></h3>
<help>"response":"OK" nshanakum a update katarvel a</help><br>
<orinak>http://api.ramenskoye.100081.ooogoroda.mobi/User.update</orinak><br>
<ul>
    <span>anpajman poxancvox parametrnern en</span>
    <li>name=(anun)</li> 
    <li>f_name=(azganun)</li>
</ul>