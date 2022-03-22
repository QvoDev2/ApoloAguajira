<?php

use Illuminate\Database\Seeder;

class UsuarioEscoltaSeeder extends Seeder
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
            ('FERNANDO ANTONIO', 'BERRIO ORTIZ', '1107096479', 'fernandoab207@gmail.com', '3222773412', '" . Hash::make('11070964791') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1107096479')),
            ('HOOVER ', 'ALDANA MOYA', '1104706008', 'hooberaldana@gmail.com', '3222773400', '" . Hash::make('11047060081') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1104706008')),
            ('IVAN ', 'VELASQUEZ GONZALEZ', '1237688001', 'ivanv2639@gmail.com', '3222770901', '" . Hash::make('12376880011') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1237688001')),
            ('DERLY JOHANNA', 'RUBIO SALAS', '1120371885', 'jhoannarubio25@gmail.com', '3222773401', '" . Hash::make('11203718851') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1120371885')),
            ('EDUARD ALEJANDRO', 'CHALA CUERVO', '1122119585', 'edward02900@gmail.com', '3222773418', '" . Hash::make('11221195851') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1122119585')),
            ('YEISON ALEXANDER', 'MONCADA DIAZ', '1124243524', 'moncadadiazj19@gmail.com', '3222773414', '" . Hash::make('11242435241') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1124243524')),
            ('MICHAEL STICK', 'PINEDA MENDIETA', '1121940066', 'maicolestiguar123@hotmail.com', '3222773417', '" . Hash::make('11219400661') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121940066')),
            ('ERLIDES ', 'DELGADO NOVOA', '1149196500', 'dylangeovannydelgado@gmail.com', '3222773415', '" . Hash::make('11491965001') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1149196500')),
            ('JEISON OSWALDO', 'MURILLO PERILLA', '1120384080', 'jeisonmurilloperilla@gmail.com', '3222770894', '" . Hash::make('11203840801') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1120384080')),
            ('EVER JOSE', 'MARTINEZ MONTERO', '1148956887', 'everjm2805@gmail.com', '3222774657', '" . Hash::make('11489568871') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148956887')),
            ('WILSON ', 'AVILA PEÑA', '1237688110', 'wilsonavilapeña@gmail.com', '3222772129', '" . Hash::make('12376881101') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1237688110')),
            ('EMILCE ', 'PALOMINO FLOREZ', '1214464489', 'emilceflorezpalomino@gmail.com', '3222773404', '" . Hash::make('12144644891') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464489')),
            ('SANABRIA ', 'GERMAN ZAMBRANO', '1122653920', 'gzsanabria1997@gmail.com', '3222770948', '" . Hash::make('11226539201') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1122653920')),
            ('EGIDIO EDUARDO', 'QUINTERO OJEDA', '80158692', 'egidioeqo2020@gmail.com', '3222770902', '" . Hash::make('801586921') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '80158692')),
            ('OMAR ANDRES', 'MARTINEZ RODRIGUEZ', '1006835859', 'martinezandes2020@gmail.com', '3222770900', '" . Hash::make('10068358591') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1006835859')),
            ('ARLEY HUMBERTO', 'MUÑOZ BETANCUR', '79755834', 'ahumbertomb23@gmail.com', '3222773419', '" . Hash::make('797558341') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '79755834')),
            ('YELBER ENRIQUE', 'CRIOLLO GONZALEZ', '1122336099', 'yilberenriquec@gmail.com', '3222773421', '" . Hash::make('11223360991') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1122336099')),
            ('VICTOR ALFONSO', 'CHAVEZ GIL', '1214464709', 'vc580661@gmail.com', '3163754984', '" . Hash::make('12144647091') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464709')),
            ('WILDER HAINOVER', 'LIEVANO JARAMILLO', '1115950086', 'wilderhainoverl@gmail.com', '3222773408', '" . Hash::make('11159500861') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1115950086')),
            ('ANGUIE PAOLA', 'URRUTIA LUNA', '1123160091', 'paolithaluna791@gmail.com', '3222773413', '" . Hash::make('11231600911') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1123160091')),
            ('LADINO ', 'TORRES DIAZ', '1120371881', 'ladinotorres4@gmail.com', '3222773423', '" . Hash::make('11203718811') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1120371881')),
            ('MIRIAM YANETH', 'OVALLE GOMEZ', '31007800', 'miriamovalle2402@gmail.com', '3222773416', '" . Hash::make('310078001') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '31007800')),
            ('KAREN YULIETH', 'CHUGA BRAVO', '1006787861', 'karenyuliethchugabravo@gmail.com', '3222773422', '" . Hash::make('10067878611') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1006787861')),
            ('MOLANO URQUINA', 'LUZ ESTELA', '1123208658', 'lucesitamolano95@gmail.com', '3222773420', '" . Hash::make('11232086581') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1123208658')),
            ('DIAZ CARDONA', 'JIMER ALEXIS', '1214464728', 'jimerdiaz90@gmail.com', '3222773409', '" . Hash::make('12144647281') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464728')),
            ('VICTOR MANUEL', 'MONTAÑA ARTUNDUAGA', '1006873258', 'montanavictor73@gmail.com', '3222770898', '" . Hash::make('10068732581') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1006873258')),
            ('ARLEY ', 'MARTINEZ ALCALA', '1214464787', 'arleym542@gmail.com', '3222773402', '" . Hash::make('12144647871') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464787')),
            ('HOLMAN ALEXANDER', 'PARRA BELTRAN', '1214464818', 'beltranholman1988@gmail.com', '3222773405', '" . Hash::make('12144648181') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1214464818')),
            ('MAYERLY ', 'VALDERRAMA VALBUENA', '1117821384', 'valderramamayerly774@gmail.com', '3222770896', '" . Hash::make('11178213841') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1117821384')),
            ('CRISTIAN YESID', 'MARTINEZ PEÑA', '1119892969', 'khristian.martinez96@gmail.com ', '3222770895', '" . Hash::make('11198929691') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1119892969')),
            ('CARLOS ANDRES', 'SANABRIA BUSTOS', '1121419035', 'andresanabria90602018@gmail.com', '3222773411', '" . Hash::make('11214190351') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121419035')),
            ('MENDEZ SOTO', 'JESUS SEBASTIAN', '1121905068', 'taisopaloma39@gmail.com', '3124614885', '" . Hash::make('11219050681') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121905068')),
            ('AVILA ESCALONA', 'DUMAR ANDRES', '1006828341', 'dumarandresavila@gmail.com', '3118044582', '" . Hash::make('10068283411') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1006828341')),
            ('BASTOS ORTIZ', 'CARLOS ANDRES', '88306209', 'cbasto1880@gmail.com', '3118477532', '" . Hash::make('883062091') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88306209')),
            ('LAMUS PARADA', 'OSCAR EDUARDO', '88227025', 'lamusoscar23@gmail.com', '3204909843', '" . Hash::make('882270251') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88227025')),
            ('MENDOZA DURAN', 'DUMAR LEONARDO', '88310043', 'dumarmendoza170@gmail.com', '3102258070', '" . Hash::make('883100431') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88310043')),
            ('MERCADO QUINTERO', 'LUIS ALBERTO', '12644671', 'luisalbertomercado054@gmail.com', '3224439824', '" . Hash::make('126446711') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '12644671')),
            ('PALLARES FRANCO', 'OMAR YESID', '1094350964', 'omarpallaresfranco@gmail.com', '3223826368', '" . Hash::make('10943509641') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1094350964')),
            ('TORO LEON', 'NELSON ', '1091162492', 'nelsontoro5710@gmail.com', '3147976608', '" . Hash::make('10911624921') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1091162492')),
            ('BELTRAN SOLANO', 'JOHAN DANIEL', '88203677', 'johanbeltran2873@gmail.com', '3502862256', '" . Hash::make('882036771') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88203677')),
            ('CABRERA PINEDA', 'VICTOR ALFONSO', '1121858328', 'victorcabrera989@gmail.com', '3124275299', '" . Hash::make('11218583281') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121858328')),
            ('CABRERA PINEDA', 'MARIA ALEJANDRA', '1121930499', 'maleja.cabrera13@gmail.com', '3115080377', '" . Hash::make('11219304991') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1121930499')),
            ('MOTAVITA ROPERO', 'ALVARO MANNUEL', '1004996518', 'alvaromanyar15@gmail.com', '3133426483', '" . Hash::make('10049965181') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1004996518')),
            ('FLOREZ ROJAS', 'JEFFERSON ALEXANDER', '1093292075', 'jeffersonalexanderflorezrojas@gmail.com', '3209112990', '" . Hash::make('10932920751') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1093292075')),
            ('SAAVEDRA CRUZ', 'DIELMAN DUVAN', '1010033602', 'dielman7777@gmail.com', '3142217375', '" . Hash::make('10100336021') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1010033602')),
            ('BENITEZ NIÑO', 'FREDY ALBERTO', '88230866', 'fredyalbertobenitez17@gmail.com', '3138848835', '" . Hash::make('882308661') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88230866')),
            ('RUEDA COBARIA', 'JHON FREDY', '88274195', 'jhonrueda31@outlook.es', '3205724953', '" . Hash::make('882741951') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88274195')),
            ('FUENTES MOLINA', 'ELIZABETH ', '1148956665', 'elizabeth2020988@gmail.com', '3108011195', '" . Hash::make('11489566651') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1148956665')),
            ('GALVIS SILVA', 'JHON HARRINSON', '88210952', 'jhon7854sg@gmail.com', '3135129691', '" . Hash::make('882109521') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '88210952')),
            ('BAUTISTA GIRALDO', 'HEIMER DAMIAN', '1005540551', 'heimer.giraldo25@gmail.com', '3107917275', '" . Hash::make('10055405511') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1005540551')),
            ('DURAN SERRANO', 'LEYDIS KATHERINE', '1051635414', 'jhareth.2316@gmail.com', '3138751192', '" . Hash::make('10516354141') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1051635414')),
            ('TELLEZ GIRALDO', 'WILFREDO ', '1091076794', 'gwilfredo820@gmail.com', '3008416819', '" . Hash::make('10910767941') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1091076794')),
            ('GOMEZ BERRIO', 'NADER YESID', '1040505435', 'naderyesidgomez@gmail.com', '3202259300', '" . Hash::make('10405054351') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1040505435')),
            ('ATENCIO BELLO', 'YEY MANUEL', '1001682735', 'corales.maria83@gmail.com', '3105985092', '" . Hash::make('10016827351') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1001682735')),
            ('RUIZ CASTELLANOS', 'DANIEL SANTIAGO', '1193543357', 'danipte211@gmail.com', '3123064555', '" . Hash::make('11935433571') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1193543357')),
            ('FIGUEROA DIAZ', 'RONALD ENRIQUE', '1065866916', 'ronaldenrriquefidiaz37@gmail.com', '3182008769', '" . Hash::make('10658669161') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1065866916')),
            ('VILLAMIZAR FLOREZ', 'JEISSON FABIAN', '1095951538', 'marthaflorezortiz@hotmail.com', '3134009596', '" . Hash::make('10959515381') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1095951538')),
            ('ZAPATA DELGADO', 'IVAN DE', '1039683047', 'ivana12061@hotmail.com', '3232292721', '" . Hash::make('10396830471') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1039683047')),
            ('THOMAS CASTRILLON', 'MAURICIO ', '13740711', 'factoryxtreme2014@gmail.com', '3152311626', '" . Hash::make('137407111') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '13740711')),
            ('QUIROGA DIAZ', 'HEINER RODOLFO', '1007952161', 'quirogaheiner708@gmail.com', '3105153509', '" . Hash::make('10079521611') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '1007952161')),
            ('RANGEL CONTRERAS', 'ADRIAN ALFONSO', '13571553', 'ar85111637062@gmail.com', '3209106729', '" . Hash::make('135715531') . "', 4, now(), now(), (SELECT id FROM escoltas WHERE identificacion = '13571553'))
        ");
    }
}
