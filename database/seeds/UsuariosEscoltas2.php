<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosEscoltas2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO users (nombres, apellidos, documento, email, celular, password, perfil_id, created_at, updated_at, escolta_id) VALUES
                ('LEIDY LORENA', 'ALCARRAS MESA','1148957056', 'leidyalcaraz@tutanota.de', '3222667321', '" . Hash::make('11489570561') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148957056')),
                ('JAIRO ENRIQUE', 'PABA REYES','1126600724', 'jairo.paba.reyes@gmail.com', '3222667331', '" . Hash::make('11266007241') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1126600724')),
                ('LUIS ALBERTO', 'CARDOZO ','1121819921', 'cardosoluisalberto74@gmail.com', '3222667325', '" . Hash::make('11218199211') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121819921')),
                ('SANDRA PATRICIA', 'VELASCO TIAFI ','1060806032', 'naiyaravelasco@gmail.com', '3222669806', '" . Hash::make('10608060321') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1060806032')),
                ('BRANDON STIVEN ', ' GARCIA RAMIREZ ','1026599877', 'steven_04gara@hotmail.com', '3222669804', '" . Hash::make('10265998771') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1026599877')),
                ('ANDRES GIOVANY', 'PASTOR RAMIREZ ','1012405816', 'ferchorolo26@hotmail.com', '3222669810', '" . Hash::make('10124058161') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1012405816')),
                ('CARLOS ANTONIO', 'RIASCOS RIASCOS','1059046328', 'cariascos@outlook.es', '3222667349', '" . Hash::make('10590463281') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1059046328')),
                ('CARMEN MARGARITA', 'CAPACHO SIERRA ','27737375', 'carmencapacho63@gmail.com', '3222667335', '" . Hash::make('277373751') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '27737375')),
                ('JOSE JAVIER', 'SANTANA MORERA','1120378864', 'javiersantanamo17@gmail.com', '3222667337', '" . Hash::make('11203788641') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1120378864')),
                ('LEIDY YOHANA', 'CERDAS ROPERO ','1148956632', 'leidycerdas164@gmail.com', '3222667348', '" . Hash::make('11489566321') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148956632')),
                ('SANDRO ALBERTO', 'CAMPOS VILLALBA ','7320206', 'campossandro081@gmail.com', '3222667334', '" . Hash::make('73202061') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '7320206')),
                ('GLORIA MILENA', 'OLIVEROS TORO ','1121840959', 'oliverosm1326@gmail.com', '3222669784', '" . Hash::make('11218409591') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121840959')),
                ('YOSUAR DAVID', 'JOVEN GUARIN ','1120382092', 'yosuarjoven@gmail.com', '3222667340', '" . Hash::make('11203820921') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1120382092')),
                ('JEDIRSON DANOVIS', 'HERRADA LOAIZA ','1133934353', 'heiyoyu@hotmail.es', '3222667341', '" . Hash::make('11339343531') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1133934353')),
                ('DEISY YOANA', 'TAPASCO GUTIERREZ','1121909992', 'deisytapascogutierrez@gmail.com', '3222667346', '" . Hash::make('11219099921') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121909992')),
                ('OSCAR EDUARDO', 'VERA BUSTOS','1110527048', 'veraoed@gmail.com', '3222667350', '" . Hash::make('11105270481') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1110527048')),
                ('JOSE JOAQUIN', 'BERNAL MONTOYA ','1111198738', 'bernalyeisson417@gmail.com', '3222667353', '" . Hash::make('11111987381') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1111198738')),
                ('FREDDY', 'IDROBO SANDOVAL','79834616', 'freddyidrobo029@gmail.com', '3222666072', '" . Hash::make('798346161') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '79834616')),
                ('REINALDO', 'FLOREZ LOPEZ ','1069757425', 'reinaldoflorezlopez@gmail.com', '3222667362', '" . Hash::make('10697574251') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1069757425')),
                ('EDIER RAFAEL', 'BUSTAMANTE MONTOYA ','1100682119', 'edier.rafael1985@gmail.com', '3222664835', '" . Hash::make('11006821191') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1100682119')),
                ('JUAN CARLOS', 'RAMIREZ VELASQUEZ ','80443358', 'ramiresjuancarlos.36@gmail.com', '3222664832', '" . Hash::make('804433581') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '80443358')),
                ('RAMIRO DE JESUS', 'ALVAREZ MANCO ','1237438016', 'ramiro18081@gmail.com', '3222664845', '" . Hash::make('12374380161') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1237438016')),
                ('LUIS EDUARDO', 'MONTERO VARGAS ','5821884', 'monteroluis274@gmail.com', '3222664852', '" . Hash::make('58218841') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '5821884')),
                ('OMAR ARMANDO ', 'MORENO TAPIA','79481262', 'omol369@yahoo.com', '3222664856', '" . Hash::make('794812621') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '79481262')),
                ('YEIMI JULIANA', 'SERNA PONCE','1148211241', 'yeimiponceserna2017@gmail.com', '3222664854', '" . Hash::make('11482112411') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148211241')),
                ('JOHN ALEXANDER', ' ROBLEDO ARDILA',' 75090968', 'roble7936@gmail.com', '3222664857', '" . Hash::make(' 750909681') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = ' 75090968')),
                ('YELI ANDREA', 'QUICENO QUICENO ','1116500414', 'yelyandreaquiceno95@gmail.com', '3222664860', '" . Hash::make('11165004141') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1116500414')),
                ('MARIA DEL AMPARO', 'MENESES ORTEGA ','1065887210', 'mariamenesesortega8711qgmail.com', '3222666048', '" . Hash::make('10658872101') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1065887210')),
                ('GILDARDO', 'GUEPENDO VANEGAS ','14297128', 'gilgv2007@gmail.com', '3222664866', '" . Hash::make('142971281') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '14297128')),
                ('JOSE IVAN', 'MORALES HUESO ','1148707089', 'jmoraleshueso@gmail.com', '3222664862', '" . Hash::make('11487070891') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148707089')),
                ('NIDIA MARLENY', 'FLOREZ GARRIDO ','1148707121', 'nicol322016@gmail.com', '3222664864', '" . Hash::make('11487071211') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148707121')),
                ('CAMILO ANDRES', 'AYALA PEÑA','1022404597', 'andreykat.04@hotmail.com', '3222666041', '" . Hash::make('10224045971') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1022404597')),
                ('FABIAN ANDRES', 'RODRIGUEZ RAMIREZ  ','1024467038', 'rodriguezfabian-@outlook.com', '3222666057', '" . Hash::make('10244670381') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1024467038')),
                ('CARLOS EDUARDO', 'GANTIVA URQUIJO ','3146440', 'cgurquijo@gmail.com', '3222666059', '" . Hash::make('31464401') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '3146440')),
                ('BRAYAN DAVID', 'ROZO ARIZA ','1026268752', 'brayam.david.rozo@gmail.com', '3222666049', '" . Hash::make('10262687521') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1026268752')),
                ('SANDRO', 'ARENAS ECEVERRY','86010644', 'john.fredy25qhotmail.es', '3222666046', '" . Hash::make('860106441') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '86010644')),
                ('MARIA VICTORIA', 'CORREA CALDAS','1007757469', 'correamariavictoria729@gmail.com', '3222666056', '" . Hash::make('10077574691') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1007757469')),
                ('WILLIAM JAVIER', 'LOPEZ BUITRAGO','88177739', 'willianlopez118@gmail.com', '3222666069', '" . Hash::make('881777391') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88177739')),
                ('LEIDY FERNANDA', 'LUNA PULGARIN ','1237688176', 'leidyluna726@gmail.com', '3222666075', '" . Hash::make('12376881761') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1237688176')),
                ('JUAN CARLOS', 'SANCHEZ COLLAZOS','1069761852', 'juancarlossc1901@gmail.com', '3222666079', '" . Hash::make('10697618521') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1069761852')),
                ('LIZETH DAYANA', 'MARIN BLANDON','1079172461', 'lizethdayanam01@gmail.com', '3222774676', '" . Hash::make('10791724611') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1079172461')),
                ('SANDRA MILENA', 'BOLAÑOS ROSADA ','36346919', 'sandrabolanosrosada@gmail.com', '3222666081', '" . Hash::make('363469191') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '36346919')),
                ('JOSE MIGUEL', 'CASTRELLON GOMEZ','1131399132', 'katar191@outlook.com', '3222667290', '" . Hash::make('11313991321') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1131399132')),
                ('HAZMIN YAMILE', 'CELIS LEON J','1149437279', 'celisjhazmin@gmail.com', '3222666090', '" . Hash::make('11494372791') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1149437279')),
                ('PAOLA ARGENIS', 'LOPEZ RIOS ','52466654', 'ecmmvdamaris@gmail.com', '3222667364', '" . Hash::make('524666541') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '52466654')),
                ('EDWIN ALFREDO', 'BERMUDEZ MARTINEZ ','1148707167', 'bermudeze812@gmail.com', '3222667347', '" . Hash::make('11487071671') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148707167')),
                ('ALEXI DE JESUS', 'GOMEZ LOPEZ ','1148435646', 'alexizgomez2089@gmail.com', '3222668585', '" . Hash::make('11484356461') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148435646')),
                ('NEFTALI', 'ABRIL ABRIL','1007842989', 'neftaliabril444@gmail.com', '3222664825', '" . Hash::make('10078429891') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1007842989')),
                ('JORGE ELIECER', 'PALENCIA CRUZ','1022971373', 'palencia-91@hotmail.com', '3222768422', '" . Hash::make('10229713731') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1022971373')),
                ('YEIMS', 'CARDONA ARIAS','1214464774', 'jamescardona43@gmail.com', '3222768419', '" . Hash::make('12144647741') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464774')),
                ('VIVIANA TERESA', 'SERENO DIAZ','1096203401', 'dannisdiaz012685@gmail.com', '3222768418', '" . Hash::make('10962034011') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1096203401')),
                ('ANA YIBE', 'TROCHEZ GOMEZ','1149196314', 'martinezdeysi237@gmail.com', '3222667361', '" . Hash::make('11491963141') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1149196314')),
                ('CARLOS ALFONSO', 'RODRIGUEZ ORTIZ ','94515651', 'carrotiz77@gmail.com', '3222768411', '" . Hash::make('945156511') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '94515651')),
                ('NELSON YESITH', 'LUENGAS MENDEZ','1023963959', 'nelsonluengas006@gmail.com', '3222768421', '" . Hash::make('10239639591') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1023963959')),
                ('HERMES ALEXIS', 'CUBURUCO ROJAS','1091076732', 'rojasalexis14081981@gmail.com', '3222768407', '" . Hash::make('10910767321') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1091076732')),
                ('MARTIN ORLANDO', 'BELTRAN RODRIGUEZ ','3064744', 'orlando.belrod.07@gmail.com', '3222666097', '" . Hash::make('30647441') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '3064744')),
                ('MILDRED', 'ABRIL ABRIL ','1193609132', 'mildred.abril2019@gmail.com', '3222768405', '" . Hash::make('11936091321') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1193609132')),
                ('VLADIMIR HUMBERTO', 'VARGAS ARIAS ','1038385858', 'vladimirvargasarias19@gmail.com', '3222773399', '" . Hash::make('10383858581') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1038385858')),
                ('MILLER FERNEY', 'LOPEZ TORRES ','1022976995', 'millerlopez9292@gmail.com', '3222768396', '" . Hash::make('10229769951') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1022976995')),
                ('LUIS OLMEDO', 'YASNO PENA','1214464592', 'yasnoluis8@gmail.com', '3222774677', '" . Hash::make('12144645921') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464592')),
                ('JOSE BLADIMIR', 'LEAL JIMENEZ','1148211226', 'bladimirlealgimenes@gmail.com', '3222773410', '" . Hash::make('11482112261') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148211226')),
                ('YOINIS JOSE', 'HERRERA SANCHEZ ','1084732095', 'yoinisjose@gmail.com', '3222667323', '" . Hash::make('10847320951') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1084732095')),
                ('FREDY', 'CASTAÑEDA HERNANDEZ','80018641', 'fredycastaneda1977@hotmail.com', '3222667355', '" . Hash::make('800186411') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '80018641')),
                ('ALBEIRO', 'GUALTEROS PULIDO','80226382', 'albeirogualterospulido@gmail.com', '3222666089', '" . Hash::make('802263821') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '80226382')),
                ('CARLOS', 'MATUK SANCHEZ ','1030538137', 'carlossancheztuk@gmail.com', '3222666105', '" . Hash::make('10305381371') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1030538137')),
                ('ROBINSON', 'TIQUE YATE','1151462042', 'tique0691@gmail.com', '3222773393', '" . Hash::make('11514620421') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1151462042')),
                ('ARGENIS', 'VELEZ SANCHEZ ','1236238437', 'velezargenis770@gmail.com', '3222774670', '" . Hash::make('12362384371') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1236238437')),
                ('JARRINSON', 'CASTELLANOS SANABRIA','1069231196', 'fransua1996@hotmail.com', '3222774663', '" . Hash::make('10692311961') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1069231196')),
                ('ANDREI ALBERTO ', 'VARGAS SALAZAR ','1071162915', 'aavesthetic@gmail.com', '3222774667', '" . Hash::make('10711629151') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1071162915')),
                ('JUAN PABLO', 'FLOREZ MESA','1000572854', 'juanpabloarmada@gmail.com', '3222769670', '" . Hash::make('10005728541') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1000572854')),
                ('JULIO CESAR', 'LUCAS PELAEZ ','14013934', 'Lucas85981@gmail.com', '3155594844', '" . Hash::make('140139341') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '14013934')),
                ('CLAUDIA PATRICIA', 'GONZALEZ DUARTE','1072364383', 'claudia011606@hotmail.com', '3138058220', '" . Hash::make('10723643831') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1072364383')),
                ('ORLANDO ENRIQUE', 'GONZALEZ ESCORCIA','72179965', 'oege2017@gmail.com', '3152389742', '" . Hash::make('721799651') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '72179965')),
                ('ALEXANDRA', 'GOMEZ LOPEZ ','1063290984', 'gomezlopezalexandra32@gmail.com', '3212452452', '" . Hash::make('10632909841') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1063290984')),
                ('FERNANDO', 'ARDILA ARIAS ','19462777', 'fernandoarar@hotmail.com', '3108005853', '" . Hash::make('194627771') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '19462777')),
                ('DANIEL', 'MAYORGA RAMIREZ','1091077279', 'danielmayorgaramirez051994@gmail.com', '3112832358', '" . Hash::make('10910772791') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1091077279')),
                ('YESSICA ALEJANDRA', 'VALENCIA RODRIGUEZ ','1214464759', '15yessicavalencia@gmail.com', '3122616877', '" . Hash::make('12144647591') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464759')),
                ('DIEGO', 'LOPEZ GRISALEZ','1116502794', 'diegolopezgrisalez17@gmail.com', '3204228056', '" . Hash::make('11165027941') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1116502794')),
                ('SINGRID NAYIVER', 'ZAPATA TABARES','1148959968', 'zapatanayiver26@gmail.com', '3227365953', '" . Hash::make('11489599681') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148959968')),
                ('JOSE ELIAS', 'CUBIDES CASAS','86005863', 'josecubides720@gmail.com', '20011431', '" . Hash::make('860058631') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '86005863'));
        ");
    }
}
