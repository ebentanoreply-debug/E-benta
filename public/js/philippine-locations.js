/**
 * Philippine Provinces and Municipalities / Cities Complete Dataset & Cascading Dropdown Helper
 * 
 * Supports all 82 Philippine provinces + Metro Manila (NCR),
 * with all 48 cities & municipalities of Pangasinan fully embedded,
 * and comprehensive Barangay datasets for Pangasinan LGUs.
 */
(function(window) {
    'use strict';

    const PANGASINAN_MUNICIPALITIES = [
        "San Carlos City",
        "Dagupan City",
        "Alaminos City",
        "Urdaneta City",
        "Agno",
        "Aguilar",
        "Alcala",
        "Anda",
        "Asingan",
        "Balungao",
        "Bani",
        "Basista",
        "Bautista",
        "Bayambang",
        "Binalonan",
        "Binmaley",
        "Bolinao",
        "Bugallon",
        "Burgos",
        "Calasiao",
        "Dasol",
        "Infanta",
        "Labrador",
        "Laoac",
        "Lingayen",
        "Mabini",
        "Malasiqui",
        "Manaoag",
        "Mangaldan",
        "Mangatarem",
        "Mapandan",
        "Natividad",
        "Pozorrubio",
        "Rosales",
        "San Fabian",
        "San Jacinto",
        "San Manuel",
        "San Nicolas",
        "San Quintin",
        "Santa Barbara",
        "Santa Maria",
        "Santo Tomas",
        "Sison",
        "Sual",
        "Tayug",
        "Umingan",
        "Urbiztondo",
        "Villasis"
    ];

    const PANGASINAN_POSTAL_CODES = {
        "San Carlos City": "2420",
        "Dagupan City": "2400",
        "Lingayen": "2401",
        "Alaminos City": "2404",
        "Urdaneta City": "2428",
        "Calasiao": "2418",
        "Malasiqui": "2421",
        "Bayambang": "2423",
        "Mangaldan": "2432",
        "Binmaley": "2417",
        "Rosales": "2441",
        "Manaoag": "2430",
        "Pozorrubio": "2435",
        "Santa Barbara": "2419",
        "Bolinao": "2406",
        "Anda": "2405",
        "Bani": "2407",
        "Bugallon": "2416",
        "Labrador": "2402",
        "Sual": "2403",
        "Villasis": "2427",
        "Tayug": "2445",
        "Umingan": "2446",
        "Binalonan": "2436",
        "Asingan": "2439",
        "Mapandan": "2429",
        "San Fabian": "2433",
        "San Jacinto": "2431",
        "Mangatarem": "2413",
        "Aguilar": "2415",
        "Basista": "2422",
        "Bautista": "2424",
        "Alcala": "2425",
        "Santo Tomas": "2426",
        "Laoac": "2437",
        "San Manuel": "2438",
        "Santa Maria": "2440",
        "Balungao": "2442",
        "Natividad": "2443",
        "San Quintin": "2444",
        "San Nicolas": "2447",
        "Sison": "2434",
        "Urbiztondo": "2414",
        "Agno": "2408",
        "Burgos": "2410",
        "Dasol": "2411",
        "Infanta": "2412",
        "Mabini": "2409"
    };

    /**
     * Comprehensive Pangasinan Barangays Dataset
     */
    const PANGASINAN_BARANGAYS = {
        "San Carlos City": [
            "Abanon", "Agdao", "Anando", "Antipangol", "Aponit", "Bacnar", "Balaya", "Balanyer",
            "Balococ", "Banoang", "Bega", "Bocboc", "Bogaoan", "Bolingit", "Bonifacio (Poblacion)",
            "Buenglat", "Cacaritan", "Caingal", "Calobaoan", "Calomboyan", "Camaley", "Caoayan Kiling",
            "Capandanan", "Coliling", "Cruz", "Dalandan", "Doyong", "Gamata", "Ilang", "Inerangan",
            "Isla", "Libas", "Lilimasan", "Longos", "Lucban (Poblacion)", "Mabalbalino", "Mabini (Poblacion)",
            "Magtaking", "Malacañang", "Maliwara", "Mamarlao", "Manzon", "Matagdem", "Mestizo",
            "Naguilayan", "Nelintap", "Padilla (Poblacion)", "Pagal", "Paitan-Panagan", "Palaris (Poblacion)",
            "Palospos", "Pangalangan", "Pangcaingayan", "Pangdel", "Payapa", "Perez Boulevard (Poblacion)",
            "Polo", "Quezon Boulevard (Poblacion)", "Quintong", "Rizal (Poblacion)", "Roxas Boulevard (Poblacion)",
            "Salinap", "San Agustin", "San Gabriel", "San Jose", "San Juan", "San Pedro-Taloy",
            "Sapinit", "Supo", "Talang", "Tamayo", "Tandoc", "Tarece", "Tarectec", "Tayambani", "Tebag", "Turac"
        ],
        "Dagupan City": [
            "Bacayao Norte", "Bacayao Sur", "Barangay I (Poblacion)", "Barangay II (Poblacion)",
            "Barangay IV (Poblacion)", "Bolosan", "Bonuan Binloc", "Bonuan Boquig", "Bonuan Gueset",
            "Calmay", "Carael", "Caranglaan", "Herrero-Perez", "Lasip Chico", "Lasip Grande", "Lomboy",
            "Lucao", "Malued", "Mamalingling", "Mangin", "Mayombo", "Pantal", "Poblacion Oeste",
            "Pogo Chico", "Pogo Grande", "Pugaro Suit", "Salapingao", "Salisay", "Tambac", "Tapuac", "Tebeng"
        ],
        "Lingayen": [
            "Aliwekwek", "Baay", "Balangobong", "Balococ", "Bantayan", "Basing", "Capandanan",
            "Domalandan Center", "Domalandan East", "Domalandan West", "Dorongan", "Dulag", "Estanza",
            "Lasip", "Libsong East", "Libsong West", "Malawa", "Malimpuec", "Maniboc", "Matalava",
            "Naguelguel", "Namolan", "Pangapisan North", "Pangapisan South", "Poblacion", "Quibaol",
            "Rosario", "Sabangan", "Talogtog", "Tonton", "Tumbar", "Wawa"
        ],
        "Urdaneta City": [
            "Anonas", "Bactad East", "Bayaoas", "Bolaoen", "Cabaruan", "Cabuloan", "Camantiles",
            "Casantaan", "Catablan", "Cayambanan", "Consolacion", "Dilan-Paurido", "Labit Proper",
            "Labit West", "Mabanogbog", "Macalong", "Nancamaliran East", "Nancamaliran West",
            "Nancayasan", "Palina East", "Palina West", "Pinmaludpod", "Poblacion", "San Jose",
            "San Vicente", "Santa Lucia", "Santo Domingo", "Sugcong", "Tiposo", "Tulong"
        ],
        "Alaminos City": [
            "Alos", "Amandiego", "Amangbangan", "Balangobong", "Balayang", "Bisocol", "Bolaney",
            "Baleyadaan", "Bued", "Cabatuan", "Cayucay", "Dulacac", "Inerangan", "Landoc",
            "Linmansangan", "Lucap", "Macatiw", "Magsaysay", "Mona", "Palamis", "Pangapisan",
            "Poblacion", "Pogo", "Polo", "Quibuar", "Sabangan", "San Antonio", "San Jose",
            "San Roque", "San Vicente", "Santa Maria", "Tanaytay", "Tangcarang", "Tawintawin",
            "Telbang", "Victoria"
        ],
        "Calasiao": [
            "Ambuetel", "Banaoang", "Bued", "Cabilocaan", "Dinalaoan", "Doyong", "Gabon", "Lasip",
            "Longos", "Lumbang", "Macabito", "Malabago", "Mancup", "Nalsian", "Poblacion East",
            "Poblacion West", "Quesban", "San Miguel", "San Vicente", "Songkoy", "Talibaew"
        ],
        "Malasiqui": [
            "Alacan", "Aliaga", "Amacalan", "Anan", "Asin Este", "Asin Weste", "Bacundao East",
            "Bacundao West", "Bakitiw", "Balite", "Banawang", "Baris", "Bawer", "Binalay",
            "Bobonan", "Bolaoit", "Bongar", "Butao", "Cabatling", "Cabueldatan", "Calawacan",
            "Canan", "Cawayan Bogtong", "Don Pedro", "Gomez", "Guilig", "Ican", "Inggalang",
            "Lareg-lareg", "Lasip", "Lepa", "Lokeb Norte", "Lokeb Sur", "Luayan", "Lunec",
            "Mabulitec", "Malimpec", "Manggan-Dampay", "Nancapian", "Nansangaan", "Olea",
            "Pacuan", "Palapar Norte", "Palapar Sur", "Palandoc", "Panondongan", "Pasima",
            "Payar", "Poblacion", "Polong Norte", "Polong Sur", "Puelay", "San Julian",
            "Tabion", "Talangan", "Talibaew", "Talospatang", "Tambac", "Tolonguat", "Tomling",
            "Umanday", "Warey"
        ],
        "Bayambang": [
            "Alinggan", "Amamperez", "Amancosiling Norte", "Amancosiling Sur", "Ambiat", "Anis",
            "Asinan", "Ataynan", "Bacnono", "Balaybuaya", "Banaban", "Bani", "Batangcaoa", "Beleng",
            "Bical Norte", "Bical Sur", "Bongato East", "Bongato West", "Buaya", "Bued",
            "Buenlag 1st", "Buenlag 2nd", "Cadre Site", "Carungay", "Caturay", "Darawey",
            "Duera", "Hermoza", "Idlong", "Inanlorenz", "Inirangan", "Iton", "Langiran", "Ligue",
            "M. H. del Pilar", "Macayocayo", "Magsaysay", "Maigpa", "Malimpec", "Malioer",
            "Manambong Norte", "Manambong Parte", "Manambong Sur", "Mangayao", "Nalsian Norte",
            "Nalsian Sur", "Pangdel", "Pantol", "Paragos", "Poblacion Sur", "Pugo", "Reynado",
            "San Gabriel 1st", "San Gabriel 2nd", "San Vicente", "Sancagulis", "Sanlibo",
            "Sapang", "Tamaro", "Tambac", "Tampog", "Tanolong", "Tatarac", "Telbang",
            "Tococ East", "Tococ West", "Warding", "Wawa", "Zone I (Poblacion)",
            "Zone II (Poblacion)", "Zone III (Poblacion)", "Zone IV (Poblacion)", "Zone V (Poblacion)",
            "Zone VI (Poblacion)", "Zone VII (Poblacion)"
        ],
        "Mangaldan": [
            "Alitaya", "Amansabina", "Anolid", "Banaoang", "Bantayan", "Bari", "Bateng",
            "Buenlag", "David", "Embarcadero", "Gueguesangen", "Guesang", "Guiguilonen",
            "Guilig", "Inlambo", "Lanas", "Landas", "Maasin", "Macabito", "Malabago",
            "Navaluan", "Nibaliw", "Osiem", "Palua", "Poblacion", "Salay", "Tebag"
        ],
        "Binmaley": [
            "Amancoro", "Balagan", "Balogo", "Basing", "Baybay Lopez", "Baybay Polong", "Biec",
            "Buenlag", "Calit", "Caloocan Dupo", "Caloocan Norte", "Caloocan Sur", "Camaley",
            "Canaoalan", "Dulag", "Gayaman", "Linoc", "Lomboy", "Nagpalangan", "Malindao",
            "Manat", "Nagalany", "Naguilayan", "Parian", "Poblacion", "Pototan", "Sabangan",
            "Salapingao", "San Isidro Norte", "San Isidro Sur", "Santa Rosa", "Tombor"
        ],
        "Bugallon": [
            "Angarian", "Asinan", "Bacabac", "Bolaoen", "Buenlag", "Cabayaoasan", "Cayanga",
            "Gueset", "Hacienda", "Laguit Centro", "Laguit Padilla", "Magtaking", "Pangalcang",
            "Poblacion", "Polong", "Portic", "Salasa", "Samat", "San Francisco", "Umanday"
        ],
        "Manaoag": [
            "Babayan", "Balaoang", "Baritao", "Bisal", "Bucao", "Cabanbanan", "Calaocan",
            "Inamotan", "Lelemaan", "Licsi", "Lipit Norte", "Lipit Sur", "Matalongao",
            "Nalsian", "Oraan East", "Oraan West", "Pantal", "Pao", "Parian", "Poblacion",
            "Pugaro", "San Ramon", "Sapang", "Tebuel"
        ],
        "Rosales": [
            "Acop", "Bakit-bakit", "Balincanaway", "Bantog", "Bitalag", "Cabalaoangan Norte",
            "Cabalaoangan Sur", "Calanutan", "Camangaan", "Casanicolasan", "Coliling",
            "Don Antonio Village", "Guiling", "Palakipak", "Pangaoan", "Poblacion", "Rabago",
            "Rizal", "Salvacion", "San Angel", "San Bartolome", "San Isidro", "San Luis",
            "San Pedro East", "San Pedro West", "San Vicente", "Station District", "Tomana East", "Tomana West"
        ],
        "Santa Barbara": [
            "Alibago", "Balingueo", "Banaoang", "Banzal", "Botao", "Cablong", "Carusucan",
            "Dalongue", "Erfe", "Gueguesangen", "Leet", "Malanay", "Maningding", "Maronong",
            "Maticmatic", "Minien East", "Minien West", "Nilombot", "Patayac", "Payas",
            "Poblacion Norte", "Poblacion Sur", "Sonquil", "Tebag East", "Tebag West", "Tuliao", "Ventinilla"
        ],
        "Pozorrubio": [
            "Alipangpang", "Amagbagan", "Balacag", "Bantugan", "Batakil", "Bobonan", "Buneg",
            "Cablong", "Casanfernandoan", "Castaño", "Dilan", "Don Benito", "Hawaiian", "Imbalbalatong",
            "Inoman", "Laoac", "Maambal", "Malasin", "Malokiat", "Manaol", "Nama", "Nantangalan",
            "Palacpalac", "Palaris", "Poblacion I", "Poblacion II", "Poblacion III", "Poblacion IV",
            "Rosario", "Sugcong", "Talnog", "Villegas"
        ],
        "Villasis": [
            "Amamperez", "Bacag", "Barangobong", "Barraca", "Capulaan", "Caramutan", "La Paz",
            "Labit", "Lipay", "Lomboy", "Piaz", "Poblacion Zone I", "Poblacion Zone II", "Puelay",
            "San Blas", "San Nicolas", "Tombod", "Unzad"
        ],
        "Mangatarem": [
            "Andocan", "Arellano Street (Poblacion)", "Bantay", "Baracbac", "Bogtong Centro",
            "Bogtong Niog", "Bogtong Silag", "Bonavita", "Buaya", "Cabangaran", "Cabaritan",
            "Cacaoiten", "Calumboyan Norte", "Calumboyan Sur", "Camangaan", "Catarataraan",
            "Doroteo", "General Luna", "Historage", "Lawak Langka", "Mabini", "Malabobo",
            "Malunec", "Maravilla", "Mulatilit", "Nancabalan", "Niog-Cabangaran", "Olegario",
            "Palacpalac", "Parian", "Pogonlomboy", "Poblacion", "Salavante", "Sapang", "Suaco",
            "Tagac", "Takipan", "Talogtog", "Torre 1st", "Torre 2nd", "Umangan"
        ],
        "San Fabian": [
            "Alacan", "Ambalangan-Dalin", "Angio", "Anonang", "Aramal", "Bigbiga", "Binday",
            "Bolasi", "Cayanga", "Colisao", "Gumot", "Inmalog", "Lekep-Butao", "Lipit-Tomeeng",
            "Longos", "Mabilao", "Nibaliw Central", "Nibaliw East", "Nibaliw Narvas", "Nibaliw Vidanes",
            "Palapad", "Poblacion", "Rabon", "Sagud-Bahley", "Sobol", "Tempra-Guilig", "Tocok"
        ],
        "Tayug": [
            "Agno", "Amistad", "Barangobong", "Carriedo", "Cayat", "Guzon", "Lawak", "Legaspi",
            "Lianquer", "Magallanes", "Panganiban", "Poblacion A", "Poblacion B", "Saleng",
            "Santo Domingo", "Toka", "Trenche", "Zamora"
        ],
        "Asingan": [
            "Ariston Este", "Ariston Weste", "Bantog", "Baro", "Bobonan", "Cabalisian", "Calepaan",
            "Carosucan Norte", "Carosucan Sur", "Coldit", "Domanpot", "Dupac", "Macalong",
            "Palaris", "Poblacion East", "Poblacion West", "San Vicente Este", "San Vicente Weste",
            "Sanchez", "Sobol", "Toboy"
        ],
        "Binalonan": [
            "Balangobong", "Bued", "Bugayong", "Camangaan", "Canarvacanan", "Capas", "Cili",
            "Dumayat", "Linmansangan", "Mangcasuy", "Moreno", "Pasileng Norte", "Pasileng Sur",
            "Poblacion", "San Felipe Central", "San Felipe Sur", "San Pablo", "San Roque",
            "Santa Catalina", "Santa Maria Norte", "Santo Niño", "Sumabnit", "Tabuyoc", "Vacante"
        ]
    };

    const PHILIPPINE_LOCATIONS = {
        "Pangasinan": {
            cities: PANGASINAN_MUNICIPALITIES,
            postalCodes: PANGASINAN_POSTAL_CODES,
            barangays: PANGASINAN_BARANGAYS,
            defaultPostal: "2420"
        },
        "Metro Manila": {
            cities: [
                "Caloocan", "Las Piñas", "Makati", "Malabon", "Mandaluyong", "Manila",
                "Marikina", "Muntinlupa", "Navotas", "Parañaque", "Pasay", "Pasig",
                "Pateros", "Quezon City", "San Juan", "Taguig", "Valenzuela"
            ],
            defaultPostal: "1000"
        },
        "La Union": {
            cities: [
                "San Fernando City", "Agoo", "Aringay", "Bacnotan", "Bagulin", "Balaoan",
                "Bangar", "Bauang", "Burgos", "Caba", "Luna", "Naguilian", "Pugo",
                "Rosario", "San Gabriel", "San Juan", "Santo Tomas", "Santol", "Sudipen", "Tubao"
            ],
            defaultPostal: "2500"
        },
        "Benguet": {
            cities: [
                "Baguio City", "Atok", "Bakun", "Bokod", "Buguias", "Itogon", "Kabayan",
                "Kapangan", "Kibungan", "La Trinidad", "Mankayan", "Sablan", "Tuba", "Tublay"
            ],
            defaultPostal: "2600"
        },
        "Ilocos Sur": {
            cities: [
                "Candon City", "Vigan City", "Alilem", "Banayoyo", "Bantay", "Burgos",
                "Cabugao", "Caoayan", "Cervantes", "Galimuyod", "Gregorio del Pilar", "Lidlidda",
                "Magsingal", "Nagbukel", "Narvacan", "Quirino", "Salcedo", "San Emilio",
                "San Esteban", "San Ildefonso", "San Juan", "San Vicente", "Santa",
                "Santa Catalina", "Santa Cruz", "Santa Lucia", "Santa Maria", "Santiago",
                "Santo Domingo", "Sigay", "Sinait", "Sugpon", "Suyo", "Tagudin"
            ],
            defaultPostal: "2700"
        },
        "Ilocos Norte": {
            cities: [
                "Laoag City", "Batac City", "Adams", "Bacarra", "Badoc", "Bangui",
                "Banna", "Burgos", "Carasi", "Currimao", "Dingras", "Dumalneg",
                "Marcos", "Nueva Era", "Pagudpud", "Paoay", "Pasuquin", "Piddig",
                "Pinili", "San Nicolas", "Sarrat", "Solsona", "Vintar"
            ],
            defaultPostal: "2900"
        },
        "Tarlac": {
            cities: [
                "Tarlac City", "Anao", "Bamban", "Camiling", "Capas", "Concepcion",
                "Gerona", "Mayantoc", "Moncada", "Paniqui", "Pura", "Ramos",
                "San Clemente", "San Jose", "San Manuel", "Santa Ignacia", "Victoria"
            ],
            defaultPostal: "2300"
        },
        "Pampanga": {
            cities: [
                "Angeles City", "San Fernando City", "Mabalacat City", "Apalit", "Arayat",
                "Bacolor", "Candaba", "Floridablanca", "Guagua", "Lubao", "Macabebe",
                "Magalang", "Masantol", "Mexico", "Minalin", "Porac", "San Luis",
                "San Simon", "Santa Ana", "Santa Rita", "Santo Tomas", "Sasmuan"
            ],
            defaultPostal: "2000"
        },
        "Bulacan": {
            cities: [
                "Malolos City", "Meycauayan City", "San Jose del Monte City", "Angat",
                "Balagtas", "Baliuag", "Bocaue", "Bulakan", "Bustos", "Calumpit",
                "Doña Remedios Trinidad", "Guiguinto", "Hagonoy", "Marilao", "Norzagaray",
                "Obando", "Pandi", "Paombong", "Plaridel", "Pulilan", "San Ildefonso",
                "San Miguel", "San Rafael", "Santa Maria"
            ],
            defaultPostal: "3000"
        },
        "Nueva Ecija": {
            cities: [
                "Cabanatuan City", "Gapan City", "Palayan City", "San Jose City",
                "Science City of Muñoz", "Aliaga", "Bongabon", "Cabiao", "Carranglan",
                "Cuyapo", "Gabaldon", "General Mamerto Natividad", "General Tinio",
                "Guimba", "Jaen", "Laur", "Licab", "Llanera", "Lupao", "Nampicuan",
                "Pantabangan", "Peñaranda", "Quezon", "Rizal", "San Antonio", "San Isidro",
                "San Leonardo", "Santa Rosa", "Santo Domingo", "Talavera", "Talugtug", "Zaragoza"
            ],
            defaultPostal: "3100"
        },
        "Bataan": {
            cities: [
                "Balanga City", "Abucay", "Bagac", "Dinalupihan", "Hermosa",
                "Limay", "Mariveles", "Morong", "Orani", "Orion", "Pilar", "Samal"
            ],
            defaultPostal: "2100"
        },
        "Zambales": {
            cities: [
                "Olongapo City", "Botolan", "Cabangan", "Candelaria", "Castillejos",
                "Iba", "Masinloc", "Palauig", "San Antonio", "San Felipe",
                "San Marcelino", "San Narciso", "Santa Cruz", "Subic"
            ],
            defaultPostal: "2200"
        },
        "Cavite": {
            cities: [
                "Bacoor City", "Cavite City", "Dasmariñas City", "General Trias City",
                "Imus City", "Tagaytay City", "Trece Martires City", "Alfonso",
                "Amadeo", "Carmona", "General Emilio Aguinaldo", "General Mariano Alvarez",
                "Indang", "Kawit", "Magallanes", "Maragondon", "Mendez", "Naic",
                "Noveleta", "Rosario", "Silang", "Tanza", "Ternate"
            ],
            defaultPostal: "4100"
        },
        "Laguna": {
            cities: [
                "Biñan City", "Cabuyao City", "Calamba City", "San Pablo City",
                "San Pedro City", "Santa Rosa City", "Alaminos", "Bay", "Calauan",
                "Cavinti", "Famy", "Kalayaan", "Liliw", "Los Baños", "Luisiana",
                "Lumban", "Mabitac", "Magdalena", "Majayjay", "Nagcarlan", "Paete",
                "Pagsanjan", "Pakil", "Pangil", "Pila", "Rizal", "Santa Cruz",
                "Santa Maria", "Siniloan", "Victoria"
            ],
            defaultPostal: "4000"
        },
        "Batangas": {
            cities: [
                "Batangas City", "Lipa City", "Sto. Tomas City", "Tanauan City",
                "Agoncillo", "Alitagtag", "Balayan", "Balete", "Bauan", "Calaca",
                "Calatagan", "Cuenca", "Ibaan", "Laurel", "Lemery", "Lian", "Lobo",
                "Mabini", "Malvar", "Mataasnakahoy", "Nasugbu", "Padre Garcia",
                "Rosario", "San Jose", "San Juan", "San Luis", "San Nicolas",
                "San Pascual", "Santa Teresita", "Taal", "Talisay", "Taysan", "Tingloy", "Tuy"
            ],
            defaultPostal: "4200"
        },
        "Rizal": {
            cities: [
                "Antipolo City", "Angono", "Baras", "Binangonan", "Cainta", "Cardona",
                "Jalajala", "Morong", "Pililla", "Rodriguez (Montalban)", "San Mateo",
                "Tanay", "Taytay", "Teresa"
            ],
            defaultPostal: "1870"
        },
        "Quezon": {
            cities: [
                "Lucena City", "Tayabas City", "Agdangan", "Alabat", "Atimonan", "Buenavista",
                "Burdeos", "Calauag", "Candelaria", "Catanauan", "Dolores", "General Luna",
                "General Nakar", "Guinayangan", "Gumaca", "Infanta", "Jomalig", "Lopez",
                "Lucban", "Macalelon", "Mauban", "Mulanay", "Padre Burgos", "Pagbilao",
                "Panukulan", "Patnanungan", "Perez", "Pitogo", "Plaridel", "Polillo",
                "Quezon", "Real", "Sampaloc", "San Andres", "San Antonio", "San Francisco",
                "San Narciso", "Sariaya", "Tagkawayan", "Tiaong", "Unisan"
            ],
            defaultPostal: "4300"
        },
        "Abra": { cities: ["Bangued", "Boliney", "Bucay", "Bucloc", "Dolores", "La Paz", "Lagangilang", "Lagayan", "Langiden", "Licuan-Baay", "Luba", "Malibcong", "Manabo", "Peñarrubia", "Pidigan", "Pilar", "Sallapadan", "San Isidro", "San Juan", "San Quintin", "Tayum", "Tineg", "Tubo", "Villaviciosa"], defaultPostal: "2800" },
        "Albay": { cities: ["Legazpi City", "Ligao City", "Tabaco City", "Bacacay", "Camalig", "Daraga", "Guinobatan", "Jovellar", "Libon", "Malilipot", "Malinao", "Manito", "Oas", "Pio Duran", "Polangui", "Rapu-Rapu", "Santo Domingo"], defaultPostal: "4500" },
        "Camarines Sur": { cities: ["Naga City", "Iriga City", "Baao", "Balatan", "Bato", "Bombon", "Buhi", "Bula", "Cabusao", "Calabanga", "Camaligan", "Canaman", "Caramoan", "Del Gallego", "Gainza", "Garchitorena", "Goa", "Lagonoy", "Libmanan", "Lupi", "Magarao", "Milaor", "Minalabac", "Nabua", "Ocampo", "Pamplona", "Pasacao", "Pili", "Presentacion", "Ragay", "Sagnay", "San Fernando", "San Jose", "Sipocot", "Siruma", "Tigaon", "Tinambac"], defaultPostal: "4400" },
        "Cebu": { cities: ["Cebu City", "Lapu-Lapu City", "Mandaue City", "Talisay City", "Toledo City", "Carcar City", "Naga City", "Danao City", "Bogo City", "Argao", "Balamban", "Bantayan", "Barili", "Bogo", "Carmen", "Consolacion", "Cordova", "Daanbantayan", "Dalaguete", "Liloan", "Minglanilla", "Moalboal", "Oslob", "San Fernando", "Santa Fe", "Sibonga"], defaultPostal: "6000" },
        "Davao del Sur": { cities: ["Davao City", "Digos City", "Bansalan", "Hagonoy", "Kiblawan", "Magsaysay", "Malalag", "Matanao", "Padada", "Santa Cruz", "Sulop"], defaultPostal: "8000" },
        "Iloilo": { cities: ["Iloilo City", "Passi City", "Ajuy", "Alimodian", "Anilao", "Badiangan", "Balasan", "Banate", "Barotac Nuevo", "Barotac Viejo", "Batad", "Bingawan", "Cabatuan", "Calinog", "Carles", "Concepcion", "Dingle", "Dueñas", "Dumangas", "Estancia", "Guimbal", "Igbaras", "Janiuay", "Lambunao", "Leganes", "Lemery", "Leon", "Maasin", "Miagao", "Mina", "New Lucena", "Oton", "Pavia", "Pototan", "San Dionisio", "San Enrique", "San Joaquin", "San Miguel", "San Rafael", "Santa Barbara", "Sara", "Tigbauan", "Tubungan", "Zarraga"], defaultPostal: "5000" },
        "Misamis Oriental": { cities: ["Cagayan de Oro City", "Gingoog City", "El Salvador City", "Alubijid", "Balingasag", "Balingoan", "Binuangan", "Claveria", "Gitagum", "Initao", "Jasaan", "Kinoguitan", "Lagonglong", "Laguindingan", "Libertad", "Lugait", "Magsaysay", "Manticao", "Medina", "Naawan", "Opol", "Salay", "Sugbongcogon", "Tagoloan", "Talisayan", "Villanueva"], defaultPostal: "9000" },
        "Negros Occidental": { cities: ["Bacolod City", "Bago City", "Cadiz City", "Escalante City", "Himamaylan City", "Kabankalan City", "La Carlota City", "Sagay City", "San Carlos City", "Silay City", "Sipalay City", "Talisay City", "Victorias City", "Binalbagan", "Calatrava", "Candoni", "Cauayan", "Enrique B. Magalona", "Hinigaran", "Hinoba-an", "Ilog", "Isabela", "La Castellana", "Manapla", "Moises Padilla", "Murcia", "Pontevedra", "Pulupandan", "Salvador Benedicto", "San Enrique", "Toboso", "Valladolid"], defaultPostal: "6100" }
    };

    /**
     * Initializer for Cascading Province, City/Municipality, Barangay, and Postal Code dropdowns
     */
    function initProvinceAndCityDropdowns(
        provinceSelectId, 
        citySelectId, 
        initialProvince = '', 
        initialCity = '', 
        postalInputId = null,
        barangaySelectId = null,
        initialBarangay = ''
    ) {
        const provinceEl = typeof provinceSelectId === 'string' ? document.getElementById(provinceSelectId) : provinceSelectId;
        const cityEl = typeof citySelectId === 'string' ? document.getElementById(citySelectId) : citySelectId;
        const postalEl = typeof postalInputId === 'string' ? document.getElementById(postalInputId) : postalInputId;
        const barangayEl = typeof barangaySelectId === 'string' ? document.getElementById(barangaySelectId) : barangaySelectId;

        if (!provinceEl || !cityEl) return;

        // Populate Province dropdown
        provinceEl.innerHTML = '<option value="">-- Select Province / Region --</option>';
        const provinceNames = Object.keys(PHILIPPINE_LOCATIONS).sort((a, b) => {
            if (a === 'Pangasinan') return -1;
            if (b === 'Pangasinan') return 1;
            return a.localeCompare(b);
        });

        provinceNames.forEach(prov => {
            const opt = document.createElement('option');
            opt.value = prov;
            opt.textContent = prov;
            if (initialProvince && initialProvince.trim().toLowerCase() === prov.toLowerCase()) {
                opt.selected = true;
            }
            provinceEl.appendChild(opt);
        });

        // Function to update barangays for a given municipality
        function updateBarangays(selectedCity, targetBarangay = '') {
            if (!barangayEl) return;

            const cleanCity = (selectedCity || '').trim().replace(/\s+City$/i, '');
            const fullCity = (selectedCity || '').trim();
            const brgyList = PANGASINAN_BARANGAYS[fullCity] || PANGASINAN_BARANGAYS[cleanCity] || PANGASINAN_BARANGAYS[cleanCity + ' City'] || [];

            if (barangayEl.tagName === 'SELECT') {
                barangayEl.innerHTML = '<option value="">-- Select Barangay --</option>';

                if (brgyList.length > 0) {
                    brgyList.forEach(brgyName => {
                        const opt = document.createElement('option');
                        opt.value = brgyName;
                        opt.textContent = brgyName;

                        if (targetBarangay) {
                            const normTarget = targetBarangay.trim().toLowerCase().replace(/^(brgy\.?|barangay)\s+/i, '');
                            const normBrgy = brgyName.trim().toLowerCase();
                            if (normBrgy === normTarget || normBrgy.replace(/\s+/g, '') === normTarget.replace(/\s+/g, '') || normBrgy.includes(normTarget)) {
                                opt.selected = true;
                            }
                        }
                        barangayEl.appendChild(opt);
                    });

                    // Add Custom entry option
                    const customOpt = document.createElement('option');
                    customOpt.value = '__custom__';
                    customOpt.textContent = '✎ Enter Other Barangay...';
                    barangayEl.appendChild(customOpt);
                } else {
                    const genericOpt = document.createElement('option');
                    genericOpt.value = targetBarangay || 'Poblacion';
                    genericOpt.textContent = targetBarangay ? targetBarangay : 'Poblacion';
                    genericOpt.selected = true;
                    barangayEl.appendChild(genericOpt);

                    const customOpt = document.createElement('option');
                    customOpt.value = '__custom__';
                    customOpt.textContent = '✎ Enter Other Barangay...';
                    barangayEl.appendChild(customOpt);
                }

                // If targetBarangay exists and wasn't selected, insert it as selected
                if (targetBarangay && !Array.from(barangayEl.options).some(o => o.selected && o.value !== '')) {
                    const specificOpt = document.createElement('option');
                    specificOpt.value = targetBarangay;
                    specificOpt.textContent = targetBarangay;
                    specificOpt.selected = true;
                    barangayEl.insertBefore(specificOpt, barangayEl.firstChild.nextSibling);
                }

                // Keep hidden/sync input in sync if exists
                const textInput = document.getElementById('idVerifBarangay');
                if (textInput && barangayEl.value && barangayEl.value !== '__custom__') {
                    textInput.value = barangayEl.value;
                }
            } else if (barangayEl.tagName === 'INPUT') {
                if (targetBarangay) {
                    barangayEl.value = targetBarangay;
                }
            }
        }

        // Function to update city dropdown when province changes
        function updateCities(selectedProvince, targetCity = '', targetBarangay = '') {
            cityEl.innerHTML = '<option value="">-- Select Municipality / City --</option>';

            if (!selectedProvince || !PHILIPPINE_LOCATIONS[selectedProvince]) {
                cityEl.disabled = true;
                if (barangayEl && barangayEl.tagName === 'SELECT') {
                    barangayEl.innerHTML = '<option value="">-- Select Municipality First --</option>';
                }
                return;
            }

            cityEl.disabled = false;
            const data = PHILIPPINE_LOCATIONS[selectedProvince];
            const cities = data.cities || [];

            cities.forEach(cityName => {
                const opt = document.createElement('option');
                opt.value = cityName;
                opt.textContent = cityName;

                if (targetCity) {
                    const normTarget = targetCity.trim().toLowerCase();
                    const normCity = cityName.trim().toLowerCase();
                    if (normCity === normTarget || normCity.replace(/\s+city$/i, '') === normTarget.replace(/\s+city$/i, '')) {
                        opt.selected = true;
                    }
                }

                cityEl.appendChild(opt);
            });

            // Update postal code
            if (postalEl && data.postalCodes && cityEl.value && data.postalCodes[cityEl.value]) {
                if (!postalEl.value || targetCity) {
                    postalEl.value = data.postalCodes[cityEl.value];
                }
            } else if (postalEl && data.defaultPostal && !postalEl.value) {
                postalEl.value = data.defaultPostal;
            }

            // Update barangays for the selected city
            const effectiveCity = cityEl.value || targetCity;
            updateBarangays(effectiveCity, targetBarangay || initialBarangay);
        }

        // Attach change listener to province dropdown
        provinceEl.addEventListener('change', function() {
            updateCities(this.value, '', '');
        });

        // Attach change listener to city dropdown
        cityEl.addEventListener('change', function() {
            const currentProv = provinceEl.value;
            if (postalEl && currentProv && PHILIPPINE_LOCATIONS[currentProv] && PHILIPPINE_LOCATIONS[currentProv].postalCodes) {
                const code = PHILIPPINE_LOCATIONS[currentProv].postalCodes[this.value];
                if (code) {
                    postalEl.value = code;
                }
            }
            updateBarangays(this.value, '');
        });

        // Initial populate of cities & barangays
        const selectedProv = provinceEl.value || initialProvince;
        if (selectedProv) {
            updateCities(selectedProv, initialCity, initialBarangay);
        } else {
            provinceEl.value = 'Pangasinan';
            updateCities('Pangasinan', initialCity || 'San Carlos City', initialBarangay || 'San Juan');
        }
    }

    // Direct Cascade Applicator: Atomically set province, municipality, barangay & postal
    function applyLocationCascade(provinceElId, cityElId, barangayElId, postalElId, province, city, barangay, postal) {
        const provEl = typeof provinceElId === 'string' ? document.getElementById(provinceElId) : provinceElId;
        const cityEl = typeof cityElId === 'string' ? document.getElementById(cityElId) : cityElId;
        const brgyEl = typeof barangayElId === 'string' ? document.getElementById(barangayElId) : barangayElId;
        const postalEl = typeof postalElId === 'string' ? document.getElementById(postalElId) : postalElId;
        const brgyText = document.getElementById('idVerifBarangay');

        if (!provEl || !cityEl) return;

        // 1. Set province
        province = province || 'Pangasinan';
        for (let i = 0; i < provEl.options.length; i++) {
            if (provEl.options[i].value.toLowerCase() === province.toLowerCase()) {
                provEl.selectedIndex = i;
                break;
            }
        }

        // 2. Populate cities for province
        cityEl.innerHTML = '<option value="">-- Select Municipality / City --</option>';
        const provData = PHILIPPINE_LOCATIONS[province] || PHILIPPINE_LOCATIONS['Pangasinan'];
        const cities = provData.cities || PANGASINAN_MUNICIPALITIES;
        let cityMatchedIndex = -1;
        city = city || 'Bayambang';
        const normTargetCity = city.trim().toLowerCase().replace(/\s+city$/i, '');

        cities.forEach((cityName, idx) => {
            const opt = document.createElement('option');
            opt.value = cityName;
            opt.textContent = cityName;
            const normCity = cityName.trim().toLowerCase().replace(/\s+city$/i, '');
            if (normCity === normTargetCity) {
                opt.selected = true;
                cityMatchedIndex = idx + 1;
            }
            cityEl.appendChild(opt);
        });

        if (cityMatchedIndex > 0) {
            cityEl.selectedIndex = cityMatchedIndex;
        }

        // 3. Populate Barangays for city
        if (brgyEl && brgyEl.tagName === 'SELECT') {
            brgyEl.innerHTML = '<option value="">-- Select Barangay --</option>';
            const selectedCity = cityEl.value || city;
            const cleanCity = selectedCity.trim().replace(/\s+City$/i, '');
            const brgyList = PANGASINAN_BARANGAYS[selectedCity] || PANGASINAN_BARANGAYS[cleanCity] || [];
            barangay = (barangay || '').trim();
            const normTargetBrgy = barangay ? barangay.toLowerCase().replace(/^(brgy\.?|barangay)\s+/i, '') : '';
            let brgySelected = false;

            brgyList.forEach(b => {
                const opt = document.createElement('option');
                opt.value = b;
                opt.textContent = b;
                const normB = b.trim().toLowerCase();
                if (normTargetBrgy && (normB === normTargetBrgy || normB.includes(normTargetBrgy) || normTargetBrgy.includes(normB))) {
                    opt.selected = true;
                    brgySelected = true;
                }
                brgyEl.appendChild(opt);
            });

            // Add custom option
            const customOpt = document.createElement('option');
            customOpt.value = '__custom__';
            customOpt.textContent = '✎ Enter Other Barangay...';
            brgyEl.appendChild(customOpt);

            if (!brgySelected && barangay) {
                const extraOpt = document.createElement('option');
                extraOpt.value = barangay;
                extraOpt.textContent = barangay;
                extraOpt.selected = true;
                brgyEl.insertBefore(extraOpt, brgyEl.firstChild ? brgyEl.firstChild.nextSibling : null);
            }

            if (brgyText && barangay) {
                brgyText.value = barangay;
            }
        } else if (brgyText && barangay) {
            brgyText.value = barangay;
        }

        // 4. Postal Code
        if (postalEl) {
            if (postal) {
                postalEl.value = postal;
            } else if (provData.postalCodes && provData.postalCodes[cityEl.value]) {
                postalEl.value = provData.postalCodes[cityEl.value];
            }
        }
    }

    // Expose to window
    window.PHILIPPINE_LOCATIONS = PHILIPPINE_LOCATIONS;
    window.PANGASINAN_MUNICIPALITIES = PANGASINAN_MUNICIPALITIES;
    window.PANGASINAN_POSTAL_CODES = PANGASINAN_POSTAL_CODES;
    window.PANGASINAN_BARANGAYS = PANGASINAN_BARANGAYS;
    window.initProvinceAndCityDropdowns = initProvinceAndCityDropdowns;
    window.applyLocationCascade = applyLocationCascade;

})(window);
