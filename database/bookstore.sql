-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Чрв 04 2025 р., 15:59
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `bookstore`
--

-- --------------------------------------------------------

--
-- Структура таблиці `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `category` enum('Ulubione','Gotowe','Czytam teraz','W planach') NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `bookmark_position` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `archive`
--

INSERT INTO `archive` (`id`, `id_user`, `id_book`, `category`, `added_on`, `bookmark_position`) VALUES
(5, 3, 5, 'Czytam teraz', '2025-01-06 14:26:15', 0),
(8, 3, 17, 'Gotowe', '2025-04-18 21:06:26', 0),
(9, 3, 12, 'Ulubione', '2025-05-28 15:44:09', 0),
(10, 3, 19, 'W planach', '2025-05-28 15:47:10', 0),
(13, 3, 16, 'Czytam teraz', '2025-06-03 12:37:54', 0),
(14, 4, 49, 'Ulubione', '2025-06-04 12:06:49', 0),
(15, 4, 61, 'Czytam teraz', '2025-06-04 12:08:20', 0),
(16, 4, 33, 'Gotowe', '2025-06-04 12:08:44', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `published_year` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `book_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `books`
--

INSERT INTO `books` (`id_book`, `title`, `author`, `genre`, `description`, `cover_image`, `published_year`, `created_at`, `book_file`) VALUES
(5, 'Kochanek Lady Chatterley', 'David Herbert Lawrence (tłum. Aleksandra Sekuła, Marceli Tarnowski)', 'romance', '\"Kochanek Lady Chatterley\" autorstwa D.H. Lawrence’a to powieść opowiadająca historię miłości i pożądania, która przełamuje bariery społeczne i konwenanse. Główna bohaterka, Constance Reid, żyje w małżeństwie z Cliffordem Chatterleyem, bogatym, ale zimnym i sparaliżowanym mężczyzną. Znudzona pustką swojego życia i emocjonalną obojętnością męża, Constance nawiązuje romans z Oliverem Mellorsem, prostym leśniczym na posiadłości Chatterleyów. Ich związek, będący zarówno duchową, jak i fizyczną więzią, staje się aktem buntu wobec społeczeństwa zdominowanego przez podziały klasowe i moralne ograniczenia. Powieść, znana ze swojej szczerości w przedstawianiu erotyki, wywołała kontrowersje i zakazy po publikacji w 1928 roku. Jednocześnie jest to głęboka refleksja nad potrzebą bliskości, prawdziwego uczucia i ludzkiej autentyczności. \"Kochanek Lady Chatterley\" pozostaje jednym z najważniejszych dzieł literatury XX wieku.', 'uploads/677b0a7d14d17_lawrence-kochanek-lady-chatterley_wfGC4O0.jpg', 1928, '2025-01-05 22:41:01', 'uploads/677b0a7d14e99_lawrence-kochanek-lady-chatterley.pdf'),
(6, 'Kasia. Legenda zapomnianej ikony Marca \'68\'', 'Jerzy Kelner', 'history', 'Konstancja Halina Surmacz – Małochleb, studentka Wydziału Elektrycznego PWr, zapisała się w historii jako jedna z najbardziej niezwykłych postaci opozycji Marca 1968, określana przez KC PZPR jako \"najgroźniejsza w Polsce\". Uratowała wrocławskie wodociągi, wprowadziła ozonowanie wody, projektowała linie energetyczne i kierowała wieloma kluczowymi inwestycjami. Mimo sukcesów, jej życie naznaczone było prześladowaniami ze strony służb bezpieczeństwa, które wpłynęły na każdą sferę jej życia, od studiów po rodzinę. W 1989 roku zaangażowała się w organizację Komitetów Obywatelskich, pozostając aktywną na rzecz społeczeństwa. Ostatecznie prowadziła wraz z mężem gospodarstwo rolne, nie rezygnując z działalności na rzecz Polski. Jej życie, pełne osiągnięć i dramatów, kończyło się w cieniu tragicznych doświadczeń, o których trudno mówić i pisać.', 'uploads/677c5e7a446c0_Kasia.Legenda zapomnianej ikony.jfif', 2018, '2025-01-06 22:51:38', 'uploads/677c5e7a44985_Jerzy Kelner - Kasia. Legenda zapomnianej ikony Marca \'68.pdf'),
(7, 'Chrzest Świętego Włodzimierza. Legenda z historii ruskiej', 'Karel Havlíček Borovský (tł. Ryszard Gębuś)', 'history', 'Chociaż treść utworu odnosi się do księcia kijowskiego Włodzimierza I Wielkiego, żyjącego na przełomie IX i X wieku, to doskonale oddaje cechy ludzkie ponadczasowe, dążenie do nieograniczonej władzy i wiarę w to, że cel uświęca środki. Jednocześnie utwór opowiada o postaci przechodzącej wielka przemianę. Wszak książę Włodzimierz, z natury okrutny, wojowniczy i rozpustny poganin, po przyjęciu chrztu w 988 roku, odmienił się diametralnie, stając się wzorowym chrześcijaninem oraz pokojowym i miłosiernym władcą. Ta metamorfoza spowodowała, ze został uznany świętym Kościoła prawosławnego i Kościoła katolickiego.', 'uploads/677c5fbc551ab_Chrzest Świętego Wlodzimierza.jfif', 2012, '2025-01-06 22:57:00', 'uploads/677c5fbc5537e_Karel Havlíček Borovský (tłumaczenie Ryszard Gębuś) - Chrzest Świętego Włodzimierza. Legenda z historii ruskiej.pdf'),
(8, 'SB a Lech Wałęsa. Przyczynek do biografii', 'Sławomir Cenckiewicz, Piotr Gontarczyk', 'history', 'Książka omawia kontrowersyjny temat relacji między Lechem Wałęsą a komunistyczną Służbą Bezpieczeństwa, szczególnie w kontekście sprawy tajnego współpracownika \"Bolka\". Autorzy wykorzystali dostępne źródła, aby szczegółowo zbadać dokumenty SB dotyczące Wałęsy i jego rolę w systemie komunistycznym. Dr hab. Andrzej Zybertowicz zwraca uwagę, że książka nie jest oskarżeniem Wałęsy, ale raczej krytyką elit III RP, które przez lata nie pozwoliły mu uwolnić się od postkomunistycznych wpływów. Z kolei prof. Andrzej Chojnowski chwali autorów za wnikliwą kwerendę źródłową i umiejętne przeprowadzenie krytycznego rozbioru materiału. Praca ta jest ceniona za dokładność, pasję oraz staranność w badaniach historycznych.', 'uploads/677c60d2e63b5_SB a Lech Wałęsa.gif', 2008, '2025-01-06 23:01:38', 'uploads/677c60d2e651e_Sławomir Cenckiewicz, Piotr Gontarczyk - SB a Lech Wałęsa. Przyczynek do biografii.pdf'),
(9, 'Matka Polka 2018. 100 lat Pol(s)ki niepodległej', 'Mateusz Kaptur', 'history', 'Książka przedstawia historię Anastazji, której życie toczy się w ramach nieustannych poświęceń dla rodziny, a jej losy są powiązane z trudnymi doświadczeniami przodków. Opowieść zaczyna się od jej miłości, nieplanowanej ciąży i decyzji o rezygnacji z marzeń na rzecz rodziny. Zmagając się z kolejnymi wyzwaniami, bohaterka zadaje sobie pytanie o sens swojego życia i błąd, który popełniła. W tle rozgrywa się również historia społecznych oczekiwań wobec kobiet, ich ról i granic, które często stają się dla nich więzieniem. W 2018 roku, przy okazji setnej rocznicy odzyskania niepodległości, Anastazja staje przed kolejną ważną decyzją. Wraz z rodziną uczestniczy w rozmowie, która może zmienić jej dalszy los i spojrzenie na Polskę, tradycję oraz samego siebie.', 'uploads/677c6179b5140_Matka Polska 2018.jfif', 2018, '2025-01-06 23:04:25', 'uploads/677c6179b52f1_Mateusz Kaptur - Matka Polka 2018. 100 lat Pol(s)ki niepodległej.pdf'),
(10, 'Pamiętnik pani Hanki', 'Tadeusz Dołęga-Mostowicz', 'history', '\"Pamiętnik pani Hanki\" Tadeusza Dołęgi-Mostowicza to doskonała powieść łącząca elementy romansu i szpiegowskiego thrillera, jednocześnie będąca portretem kobiety w latach 30. XX wieku. Główna bohaterka, Hanka Renowicka, to żona dyplomaty, której życie wypełniają przyjęcia, plotki i spotkania z wybitnymi postaciami politycznymi, wojskowymi oraz artystami. Powieść oddaje atmosferę przedwojennego świata, w którym miłość, zdrada i intrygi przeplatają się z politycznymi aferami. Autor mistrzowsko wnika w psychologię kobiety, co sprawia, że powieść jest nie tylko rozrywką, ale także interesującą lekcją o relacjach damsko-męskich. Dzięki zabiegowi literackiemu, w którym Hanka chwali się znajomościami z wybitnymi postaciami, dzieło nabiera autentyczności. \"Pamiętnik pani Hanki\" uznawany jest za najlepszą powieść Dołęgi-Mostowicza, oferując zarówno głębię, jak i przyjemność lektury.', 'uploads/677c626970767_Pamietka pani.jfif', 1936, '2025-01-06 23:08:25', 'uploads/677c626970954_Tadeusz Dołęga-Mostowicz - Pamiętnik pani Hanki.pdf'),
(11, 'Ciemno', 'Jóhanna Jóhannssona', 'kryminal', '\"Ciemno\" autorstwa Jóhanna Jóhannssona to mroczna powieść kryminalna, która przenosi czytelnika do surowej, islandzkiej rzeczywistości. Główną bohaterką jest Lára, która po dramatycznym wydarzeniu w przeszłości wraca do rodzinnej wioski, by zmierzyć się z tajemnicą sprzed lat. W miejscowości, gdzie nic nie jest takie, jak się wydaje, bohaterka odkrywa mroczne sekrety oraz niewyjaśnione zbrodnie, które zdają się zagrażać jej życiu. Akcja książki toczy się w atmosferze nieustannego napięcia, gdzie granice między przyjacielem a wrogiem zaczynają się zacierać. Autor doskonale łączy elementy kryminału z psychologiczną głębią, oferując czytelnikom wielowarstwową opowieść o przeszłości, winie i konsekwencjach niewłaściwych wyborów. \"Ciemno\" to thriller, który nie tylko trzyma w napięciu, ale także zmusza do refleksji nad naturą ludzkich decyzji.', 'uploads/677c73ba570f5_ciemno-ragnar-jnasson.png', 2021, '2025-01-07 00:22:18', 'uploads/677c73ba5728b_Ciemnos¦Бc¦Б - Ragnar Jo¦Бnasson.pdf'),
(12, 'Szwedka', 'Ignacy Seweryn Kryński', 'kryminal', '„Szwedka” to powieść osadzona w XVIII wieku, w czasach rozbiorów Polski. Główna bohaterka, tajemnicza Szwedka, staje się częścią dramatycznych wydarzeń politycznych i narodowych, łącząc swoją historię z losami polskich patriotów. W książce przeplatają się motywy miłości, zdrady, lojalności oraz walki o niepodległość. Autor w mistrzowski sposób przedstawia konflikty wewnętrzne bohaterów, ich dylematy oraz decyzje, które mają wpływ na ich przyszłość. Powieść ukazuje również trudną sytuację Polski w okresie rozbiorów, z perspektywy jednostek uwikłanych w historię.', 'uploads/677c74d925c8f_7cfec7cfa672f2c9efcd236252bbf06d.jpg', 1930, '2025-01-07 00:27:05', 'uploads/677c74d925dff_Ewa wzywa 07- Szwedka.pdf'),
(13, 'Ofiara Polikseny', 'Marta Guzowska', 'kryminal', '\"Ofiara Polikseny\" to intrygujący kryminał autorstwa Marty Guzowskiej, który wciąga czytelnika w świat archeologii i zagadek morderstw. Akcja powieści toczy się podczas wykopalisk archeologicznych w starożytnej Troi, gdzie odnalezienie tajemniczego ciała wprowadza napięcie i mrok. Główna bohaterka, antropolożka Maria Mareno, staje przed wyzwaniem rozwikłania zagadki, której korzenie sięgają zarówno starożytnych mitów, jak i współczesnych tajemnic. Autorka w mistrzowski sposób łączy fakty historyczne z wartką akcją i niespodziewanymi zwrotami wydarzeń. Książka wyróżnia się nie tylko precyzyjnym tłem naukowym, ale również pogłębioną analizą psychologiczną postaci. \"Ofiara Polikseny\" to świetna propozycja dla miłośników kryminałów z nietuzinkowym wątkiem i głębokim spojrzeniem na ludzką naturę.', 'uploads/677c75d58def6_ofiara-polikseny-b-iext121341272.jpg', 2012, '2025-01-07 00:31:17', 'uploads/677c75d58e122_Guzowska Marta - Ofiara Polikseny.pdf'),
(14, 'Pan Samochodzik i tajemnica tajemnic', 'Zbigniew Nienacki', 'kryminal', '\"Pan Samochodzik i tajemnica tajemnic\" to opowieść o detektywie-amatorze Tomaszu, który wyrusza na Bliski Wschód, by rozwikłać zagadkę związaną z tajemniczymi dokumentami. Akcja łączy wątki sensacyjne z historycznymi, wprowadzając czytelnika w świat intryg i poszukiwań skarbów. Tomasz, dzięki swojej wiedzy i nietypowemu pojazdowi, stawia czoła licznym wyzwaniom i przeciwnikom. Powieść wciąga nieprzewidywalnymi zwrotami wydarzeń oraz szczegółowymi opisami miejsc i kultury. To połączenie przygody, wiedzy i napięcia, które na długo zapada w pamięć.', 'uploads/677c763f3f44c_pan-samochodzik-i-tajemnica-tajemnic-b-iext146849924.jpg', 1975, '2025-01-07 00:33:03', 'uploads/677c763f3f621_Cykl-Pan Samochodzik (10) Tajemnica tajemnic - Zbigniew Nienacki.pdf'),
(15, 'Zbrodnia i kara', 'Fiodor Dostojewski', 'kryminal', '\"Zbrodnia i kara\" to klasyczna powieść Fiodora Dostojewskiego, która zgłębia psychologię człowieka targanego moralnymi rozterkami. Główny bohater, Rodion Raskolnikow, dokonuje morderstwa, które miało być potwierdzeniem jego teorii o \"nadludziach\". Jednak zamiast triumfu rodzi się w nim poczucie winy i wewnętrzne rozdarcie, które prowadzi do stopniowego upadku. Powieść porusza tematy moralności, sprawiedliwości i odkupienia, ukazując głęboką analizę ludzkiej duszy. To arcydzieło literatury światowej, które stawia fundamentalne pytania o naturę zła i możliwości odkupienia win.', 'uploads/677c76dfd785a_Zbrodnia-i-kara-Fiodor-Dostojewski-23162-400x624-nobckgr.webp', 1866, '2025-01-07 00:35:43', 'uploads/677c76dfd79bc_zbrodnia i kara.pdf'),
(16, 'Dożywocie', 'Marta Kisiel', 'fantasy', '\"Dożywocie\" to pełna humoru i absurdalnych sytuacji powieść, która przenosi czytelnika do Lichotki – starego domu pełnego nietuzinkowych mieszkańców. Głównym bohaterem jest Konrad Romańczuk, pisarz, który niespodziewanie dziedziczy ten niezwykły majątek. Szybko odkrywa, że nie jest tam sam – towarzyszą mu duch romantycznego poety, anioł stróż o specyficznych zainteresowaniach kulinarnych, a także rozgadane stwory. W tym nieprzewidywalnym świecie normalność nie istnieje, a życie staje się serią dziwacznych przygód. Marta Kisiel mistrzowsko łączy groteskę z błyskotliwym dowcipem, tworząc książkę, która bawi i wciąga od pierwszych stron. To idealna lektura dla miłośników literatury z przymrużeniem oka.', 'uploads/677d14968e2a8_kisiel-marta-dozywocie.jpg', 2010, '2025-01-07 11:48:38', 'uploads/677d14968e572_Marta Kisiel - DoA¦КT-ywocie.pdf'),
(17, 'Kameleon', 'Rafał Kosik', 'fantasy', '\"Kameleon\" to fascynująca powieść science fiction, która przenosi czytelnika na odległą planetę Fermi, gdzie ludzka kolonia zmaga się z tajemniczymi zjawiskami. W obliczu nieprzewidywalnych zmian klimatycznych, nieustannych zagrożeń i niewytłumaczalnych zdarzeń, grupa badaczy próbuje rozwikłać zagadkę planety, której środowisko wydaje się niemal żywe. Rafał Kosik mistrzowsko buduje atmosferę napięcia, łącząc elementy naukowe z refleksją nad ludzką naturą i przetrwaniem. To książka, która zmusza do myślenia, jednocześnie wciągając czytelnika w pełen emocji świat. Idealna dla fanów ambitnej literatury science fiction.', 'uploads/677d14fda23df_878537-352x500.jpg', 2008, '2025-01-07 11:50:21', 'uploads/677d14fda2779_Kosik RafaA¦КTВ - Kameleon.pdf'),
(18, 'Lód', 'Jacek Dukaj', 'fantasy', ' \"Lód\" to monumentalna powieść Jaceka Dukaja, która łączy historię alternatywną, filozofię i science fiction. Akcja rozgrywa się w rzeczywistości, gdzie wybuch Tunguski z 1908 roku zahamował bieg historii, powodując globalne ochłodzenie. Świat opanował lód, a wraz z nim tajemnicze, nadprzyrodzone byty – lutowie. Główny bohater, Benedykt Gierosławski, zostaje wysłany na Syberię, by odnaleźć swojego ojca, ale jego podróż szybko nabiera wymiaru metafizycznego. Dukaj tworzy wciągający, alternatywny świat, bogaty w szczegóły i pełen intelektualnych wyzwań. To książka, która angażuje zarówno wyobraźnię, jak i umysł, oferując czytelnikowi fascynującą podróż przez historię i ludzką naturę.', 'uploads/677d15571d7f5_lod-b-iext147498998.jpg', 2007, '2025-01-07 11:51:51', 'uploads/677d15571db13_Jacek Dukaj - Lo¦Бd.pdf'),
(19, 'Szczęśliwa Ziemia', 'Łukasz Orbitowski', 'fantasy', '\"Szczęśliwa Ziemia\" to powieść łącząca elementy realizmu magicznego z mroczną, psychologiczną narracją. Historia skupia się na grupie przyjaciół z małego miasteczka, których życie na zawsze zmienia wydarzenie z młodości. Powracają po latach, aby zmierzyć się z tajemnicą i legendą, która wciąż rzuca cień na ich życie. Orbitowski, mistrzowsko balansując między rzeczywistością a iluzją, przedstawia uniwersalne tematy takie jak przyjaźń, zdrada i poszukiwanie szczęścia. Książka stanowi refleksję nad dorosłością i konsekwencjami wyborów podjętych w młodości.', 'uploads/677d15e6b5bd3_szczesliwa-ziemia-b-iext167035549.jpg', 2013, '2025-01-07 11:54:14', 'uploads/677d15e6b5f01_Szcze¦иs¦Бliwa ziemia - +Бukasz Orbitowski.pdf'),
(21, 'Fiolet', 'Magdalena Kozak', 'przygody', '\"Fiolet\" to wciągająca powieść science fiction autorstwa Magdaleny Kozak, w której ludzkość staje w obliczu zagrożenia z zupełnie nowej perspektywy. W książce poznajemy świat, gdzie wojna i przemoc przenikają codzienność, a zaawansowana technologia i obce formy życia zmuszają ludzi do redefinicji swoich wartości. Główna bohaterka, uwikłana w konflikt na skalę międzygalaktyczną, musi podjąć trudne decyzje, które mogą wpłynąć na losy całej ludzkości. Powieść zachwyca dynamiczną akcją, głębokimi postaciami i filozoficznymi rozważaniami nad sensem życia i człowieczeństwa. Kozak mistrzowsko łączy elementy militarnego science fiction z psychologiczną głębią, tworząc dzieło pełne napięcia i emocji.', 'uploads/677d1868de38e_126804-352x500.jpg', 2010, '2025-01-07 12:04:56', 'uploads/677d1868de73f_Kozak Magdalena - Fiolet.pdf'),
(22, 'Kłamca. Zbiorowa Tricksteria', 'Jakub Ćwiek', 'przygody', '\"Kłamca. Zbiorowa Tricksteria\" to ostatnia część popularnej serii fantasy autorstwa Jakuba Ćwieka, koncentrującej się na postaci Lokiego – nordyckiego boga kłamstw i oszustw. W tej odsłonie Loki kontynuuje swoje pełne intryg i zaskakujących zwrotów akcji przygody, angażując się w konflikty między mitologicznymi światami. Książka jest pełna błyskotliwego humoru, dynamicznych dialogów i nieoczekiwanych wydarzeń. Ćwiek mistrzowsko łączy elementy współczesności z mitologią, tworząc unikalny świat pełen bogów, aniołów i demonów. Powieść podkreśla motywy oszustwa, manipulacji i walki o władzę, a jednocześnie porusza głębsze pytania o naturę prawdy i kłamstwa. To doskonałe zwieńczenie serii, które z pewnością zadowoli zarówno starych, jak i nowych fanów.', 'uploads/677d18dc26044_4299907264242.webp', 2020, '2025-01-07 12:06:52', 'uploads/677d18dc2646d_K+Вamca. Zbiorowa tricksteria - Jakub C¦Бwiek.pdf'),
(23, 'Kapelusz za sto tysięcy', 'Adam Bahdaj', 'przygody', '\"Kapelusz za sto tysięcy\" to kultowa powieść młodzieżowa autorstwa Adama Bahdaja, która łączy elementy przygody i kryminału. Główna bohaterka, Krysia Cuchowska, w czasie wakacji nad morzem przypadkowo trafia na trop intrygującej zagadki związanej z tajemniczym kapeluszem, w którym ukryto cenny skarb. Razem z nowo poznanym chłopcem, Pawłem, podejmuje próbę rozwikłania tajemnicy, co prowadzi do wielu niezwykłych przygód. Książka pełna jest napięcia, humoru i wciągających zwrotów akcji, które trzymają czytelnika w napięciu do ostatniej strony. Bahdaj doskonale oddaje atmosferę wakacyjnej beztroski i młodzieńczego zapału do odkrywania tajemnic. Powieść cieszy się niesłabnącą popularnością i uważana jest za klasykę polskiej literatury dziecięcej i młodzieżowej.', 'uploads/677d192c9f946_352x500.jpg', 1966, '2025-01-07 12:08:12', 'uploads/677d192c9fca3_Bahdaj Adam 1966 - Kapelusz Za Sto TysiA¦ИTЩcy .pdf'),
(24, 'Reputacja', 'Andrzej Pilipiuk', 'przygody', '\"Reputacja\" to zbiór opowiadań autorstwa Andrzeja Pilipiuka, znanego z zamiłowania do historii, tajemnic i niezwykłych bohaterów. Książka składa się z kilku niezależnych historii, które łączy motyw reputacji – jej zdobywania, utraty i obrony. Pilipiuk z charakterystycznym humorem i błyskotliwością prowadzi czytelnika przez różnorodne światy, od współczesności po przeszłość, w których magia i niezwykłe wydarzenia są na porządku dziennym. Każde opowiadanie to pełna napięcia, często zabawna, ale również refleksyjna historia, która ukazuje różnorodne oblicza ludzkich losów i charakterów. Autor zgrabnie łączy fantastykę z realizmem, tworząc opowieści, które zarówno bawią, jak i skłaniają do przemyśleń.', 'uploads/677d19836b5bb_995816-352x500.jpg', 2020, '2025-01-07 12:09:39', 'uploads/677d19836b969_Andrzej Pilipiuk - Reputacja.pdf'),
(25, 'Ryby śpiewają w Ukajali', 'Arkady Fiedler', 'przygody', '„Ryby śpiewają w Ukajali” to fascynująca relacja z podróży Arkadego Fiedlera do Peru, ukazująca życie w dżungli amazońskiej. Autor opisuje bujną przyrodę, egzotyczne zwierzęta i rośliny oraz codzienne życie Indian, z którymi zetknął się podczas wyprawy. Fiedler, obdarzony niezwykłą wrażliwością i pasją odkrywcy, przedstawia nie tylko uroki tropików, ale także trudności i niebezpieczeństwa towarzyszące eksploracji nieznanych terenów. Książka łączy elementy reportażu i literatury przygodowej, tworząc barwną i wciągającą opowieść. Tytułowe „śpiewające ryby” stają się metaforą bogactwa i tajemnic natury, która zachwyca i inspiruje. Dzieło do dziś uchodzi za jedno z najbardziej znanych i cenionych w twórczości Arkadego Fiedlera.', 'uploads/677d1a05ac699_Ryby-spiewaja-w-Ukajali-Arkady-Fiedler-AUTOGRAF.jpeg', 1935, '2025-01-07 12:11:49', 'uploads/677d1a05ac9a9_Fiedler Arkady - Ryby s¦Бpiewaja¦и w Ukajali.pdf'),
(26, 'Historia jednego uczucia', 'Kinga Michałowska', 'romance', 'Historia jednego uczucia. To historia jednej, nie do końca idealnej miłości.', 'uploads/677d1ae2ac955_Historia jednego uczucia.jfif', 2017, '2025-01-07 12:15:30', 'uploads/677d1ae2acda8_Kinga Michałowska - Historia jednego uczucia.pdf'),
(27, '', '', 'romance', NULL, 'uploads/677d1b83501d8_Serwantka.jfif', 2006, '2025-01-07 12:18:11', 'uploads/677d1b835047c_Monika Sawicka - Serwantka.pdf'),
(28, 'Afryka Kazika', 'Łukasz Wierzbicki', 'dla dzieci', '„Afryka Kazika” to opowieść inspirowana prawdziwymi przygodami Kazimierza Nowaka, który w latach 30. XX wieku przemierzył Afrykę na rowerze. Książka jest napisana w formie lekkich i przystępnych opowiadań, które przenoszą czytelnika w świat egzotycznych krajobrazów, niezwykłych przygód i spotkań z mieszkańcami Afryki. Wierzbicki z niezwykłą umiejętnością oddaje ducha podróży, podkreślając odwagę, wytrwałość i otwartość głównego bohatera na inne kultury. To inspirująca książka, która pokazuje, że marzenia można spełniać, niezależnie od przeciwności losu. Dzieło przeznaczone zarówno dla młodszych, jak i starszych czytelników, łączy edukację z dobrą zabawą. Ilustracje i humor wplecione w tekst sprawiają, że książka szybko zyskuje sympatię każdego, kto sięgnie po jej strony. Idealna pozycja dla miłośników przygód i podróży.', 'uploads/677d1ccc5b083_1129588-352x500.jpg', 2008, '2025-01-07 12:23:40', 'uploads/677d1ccc5b359_+Бukasz Wierzbicki - Afryka Kazika.pdf'),
(29, 'Akademia Pana Kleksa', 'Jan Brzechwa', 'dla dzieci', '\"Akademia Pana Kleksa\" to jedna z najbardziej znanych polskich książek dla dzieci, która przenosi czytelnika do magicznego świata pełnego niezwykłych przygód. Tytułowa akademia to szkoła prowadzona przez ekscentrycznego i charyzmatycznego Pana Kleksa, w której uczą się wyłącznie chłopcy o imionach zaczynających się na literę \"A\". Szkoła jest pełna tajemnic i magii – uczniowie poznają tam nietypowe przedmioty, takie jak kleksografia czy leczenie chorych sprzętów. Głównym narratorem jest Adaś Niezgódka, który z fascynacją opowiada o swoich doświadczeniach w Akademii. Książka porusza tematy przyjaźni, samodyscypliny oraz kreatywności, a także ukazuje, jak ważna jest wyobraźnia w codziennym życiu. Z niezwykłymi pomysłami i niecodziennym humorem, powieść Jana Brzechwy stała się klasyką literatury dziecięcej, uwielbianą zarówno przez młodszych, jak i starszych czytelników. To lektura, która zachwyca i inspiruje kolejne pokolenia.', 'uploads/677d1d550ee13_206835-352x500.jpg', 1946, '2025-01-07 12:25:57', 'uploads/677d1d550f0c3_Jan Brzechwa - Akademia Pana Kleksa.pdf'),
(30, 'Damy, dziewuchy, dziewczyny. Historia w spódnicy', 'Anna Dziewit-Meller', 'dla dzieci', '\"Damy, dziewuchy, dziewczyny. Historia w spódnicy\" to fascynująca opowieść o niezwykłych kobietach, które zapisały się na kartach historii. Anna Dziewit-Meller przedstawia czytelnikom postaci zarówno dobrze znane, jak i te mniej oczywiste, ukazując ich odwagę, determinację oraz wkład w rozwój kultury, nauki czy polityki. Książka opowiada o bohaterkach, które przełamywały stereotypy i nie bały się iść pod prąd w swoich czasach. Napisana z humorem, przystępnym językiem i wzbogacona ilustracjami Joanny Rusinek, książka stanowi doskonałą lekturę zarówno dla młodszych, jak i starszych odbiorców. To inspirująca historia o sile kobiet i ich niezwykłych osiągnięciach, która nie tylko edukuje, ale i zachęca do refleksji nad rolą kobiet w społeczeństwie.', 'uploads/677d1db0db14e_damy-dziewuchy-dziewczyny-historia-w-spodnicy-b-iext166988840.jpg', 2017, '2025-01-07 12:27:28', 'uploads/677d1db0db42f_Dziewit-Meller Anna - Damy dziewuchy dziewczyny.pdf'),
(31, 'Król Maciuś Pierwszy', 'Janusz Korczak', 'dla dzieci', '\"Król Maciuś Pierwszy\" to jedna z najważniejszych książek Janusza Korczaka, opowiadająca o przygodach małego chłopca, który niespodziewanie zostaje królem. Młody Maciuś stara się pogodzić dziecięce marzenia z trudną odpowiedzialnością rządzenia państwem. Zmagając się z politycznymi intrygami, wojną i reformami, próbuje stworzyć królestwo, w którym dzieci będą miały głos. To pełna ciepła, humoru i refleksji historia o dorastaniu, przyjaźni i odwadze w podejmowaniu decyzji. Książka porusza ważne tematy, takie jak demokracja, prawa dzieci i znaczenie empatii. Dzięki uniwersalnemu przesłaniu i ponadczasowym wartościom \"Król Maciuś Pierwszy\" pozostaje klasyką literatury dziecięcej.', 'uploads/677d1dfc0be01_krol-macius-pierwszy_Ox1oaSS.jpg', 1923, '2025-01-07 12:28:44', 'uploads/677d1dfc0e9db_krol-macius-pierwszy.pdf'),
(32, 'Ten Obcy', 'Irena Jurgielewiczowa', 'dla dzieci', '\"Ten Obcy\" to jedna z najważniejszych powieści młodzieżowych autorstwa Ireny Jurgielewiczowej, która porusza temat dorastania, odpowiedzialności i empatii. Historia opowiada o grupie przyjaciół, którzy na małej wyspie spotykają tajemniczego chłopca – Zenka. Jego obecność wprowadza niepokój, ale także zacieśnia więzi między dziećmi, które starają się mu pomóc w trudnej sytuacji życiowej. Powieść wnikliwie ukazuje różne postawy wobec inności i potrzebę solidarności w obliczu problemów. To głęboko emocjonalna opowieść o przyjaźni, zrozumieniu i trudnych wyborach, z którą młodzi czytelnicy mogą się utożsamić. Książka zdobyła uznanie zarówno w Polsce, jak i za granicą, stając się klasyką literatury dziecięcej i młodzieżowej.', 'uploads/677d1e5516ccf_Ten-obcy.jpg', 1961, '2025-01-07 12:30:13', 'uploads/677d1e5516f8e_Irena Jurgielewiczowa - Ten obcy.pdf'),
(33, 'Fourth Wing. Czwarte skrzydło', 'Rebecca Yarros', 'romance', 'Fourth Wing. Czwarte skrzydło to pierwsza część serii The Empyrean autorstwa Rebecci Yarros. Powieść opowiada historię Violet Sorrengail, młodej kobiety, która zmuszona jest do wstąpienia do brutalnej akademii wojskowej, gdzie uczniowie uczą się sztuki walki i latania na smokach. Violet, choć początkowo nieprzygotowana na surowe życie w akademii, stopniowo odkrywa swoje ukryte zdolności i staje przed trudnymi wyborami. W miarę jak zbliża się do tajemniczego i niebezpiecznego Xadena Riorsona, nie tylko musi walczyć o przetrwanie, ale także zmagać się z rosnącym uczuciem, które może ją zgubić. Powieść łączy elementy romansu, fantastyki i przygody, wciągając czytelnika w pełen emocji świat pełen smoków, walk i nieoczekiwanych zwrotów akcji.', 'uploads/677d37b2a55e8_Fourth_Wing._Czwarte_skrzydlo.jpeg', 2023, '2025-01-07 14:18:26', 'uploads/677d37b2a577e_Fourth_Wing._Czwarte_skrzydlo_dodatkowe_rozdzialy.pdf'),
(35, 'Karl_Dedecius', 'Krzysztof A. Kuczyński', 'biography', 'Karl Dedecius to książka autorstwa Krzysztofa A. Kuczyńskiego, poświęcona życiu i twórczości jednego z najwybitniejszych tłumaczy literatury polskiej na język niemiecki – Karla Dedeciusa. Kuczyński w swojej pracy przedstawia postać Dedeciusa, który odegrał kluczową rolę w popularyzowaniu polskiej literatury w Niemczech. Autor omawia nie tylko twórczość translatorską Dedeciusa, ale także jego wkład w dialog kulturowy pomiędzy Polską a Niemcami. Książka analizuje jego filozofię tłumaczenia, proces pracy nad tekstami oraz znaczenie jego tłumaczeń dla rozwoju literackiego mostu między tymi dwoma narodami. Kuczyński skupia się na złożoności i trudności tłumaczenia literatury, ukazując Dedeciusa jako nie tylko mistrza języka, ale także jako osobę, która poprzez swoje prace wzbogaciła i pogłębiła zrozumienie polskiej kultury i literatury w niemieckojęzycznym świecie.', 'uploads/677d388f43dbf_Karl_Dedecius.jpeg', 2013, '2025-01-07 14:22:07', 'uploads/677d388f43f54_Karl_Dedecius.pdf'),
(36, 'Moja mała trylogia', 'Beniamin Tytus Muszyński', 'biography', 'Moja mała trylogia to debiutancka powieść Beniamina Tytusa Muszyńskiego, która łączy w sobie elementy powieści obyczajowej, psychologicznej i filozoficznej. Autor przedstawia trzy różne historie, które razem tworzą refleksyjny obraz współczesnego życia i zmagań wewnętrznych bohaterów. W książce pojawiają się motywy miłości, przyjaźni, a także poszukiwania sensu życia w świecie pełnym niepewności i zmienności. Narracja jest głęboko introspektywna, a bohaterowie muszą zmierzyć się z własnymi dylematami, emocjami i wyborami. Powieść porusza kwestie tożsamości, samotności oraz relacji międzyludzkich, oferując czytelnikom wnikliwą analizę współczesnych problemów i wyzwań, z którymi zmaga się młode pokolenie.', 'uploads/677d38cde892c_Moja_mala_trylogia.jpeg', 2018, '2025-01-07 14:23:09', 'uploads/677d38cde8aee_Moja_mala_trylogia.pdf'),
(37, 'Moje życie', 'Krystyna Śreniowska', 'biography', 'Moje życie to książka autorstwa Krystyny Śreniowskiej, która jest autobiograficzną opowieścią o życiu autorki, pełnym wyzwań, trudnych wyborów i głębokich refleksji. Śreniowska w swojej książce dzieli się osobistymi doświadczeniami, które kształtowały jej tożsamość i spojrzenie na świat. Autorka opowiada o swojej drodze życiowej, o przeszłości, która miała wpływ na jej teraźniejszość, oraz o tym, jak życie uczyło ją pokory, mądrości i odwagi. Książka jest pełna emocji i szczerości, ukazując historię, w której przewija się wątek miłości, walki o siebie i zrozumienia własnych pragnień oraz potrzeb. W \"Moim życiu\" Krystyna Śreniowska stawia pytania o sens istnienia, relacje międzyludzkie oraz to, co jest naprawdę ważne w życiu.', 'uploads/677d3924488d8_Moje życie.jpeg', 2014, '2025-01-07 14:24:36', 'uploads/677d392448a79_Moje_zycie.pdf'),
(38, 'Wałęsa – człowiek na smyczy?', 'Krzysztof Wyszkowski', 'biography', 'Książka Wałęsa – człowiek na smyczy? autorstwa Krzysztofa Wyszkowskiego stawia kontrowersyjne tezy dotyczące Lecha Wałęsy, lidera Solidarności i późniejszego prezydenta Polski. Wyszkowski sugeruje, że Wałęsa miał współpracować z komunistycznymi służbami bezpieczeństwa, a jego działalność opozycyjna była w pewnym stopniu kontrolowana przez władze PRL. Autor, opierając się na materiałach archiwalnych i własnych badaniach, stara się udowodnić, że Wałęsa był \"człowiekiem na smyczy\", zmanipulowanym przez władze. Książka wywołała ogromne kontrowersje, szczególnie w kontekście jego pozycji bohatera narodowego, i zmusiła do refleksji nad jego rolą w obaleniu komunizmu. Wyszkowski krytycznie analizuje postać Wałęsy, przedstawiając ją w zupełnie innym świetle niż to, które było powszechnie przyjęte w Polsce po 1989 roku.', 'uploads/677d39846f86c_wałęsa - człowiek.jfif', 1992, '2025-01-07 14:26:12', 'uploads/677d39846fa1e_Krzysztof Wyszkowski - Wałęsa - człowiek na smyczy_.pdf'),
(39, 'Królewstwo I. Jego cienie', 'Agnieszka Hałas', 'horror', 'Królewstwo I. Jego cienie to opowiadanie autorstwa Agnieszki Hałas, które łączy w sobie elementy fantasy, baśni i psychologicznej głębi. Opowiadanie przedstawia świat pełen tajemnic, w którym główny bohater staje przed wieloma wyzwaniami, zarówno zewnętrznymi, jak i wewnętrznymi. Królestwo, które zostaje przedstawione w opowieści, jest miejscem, w którym rzeczywistość przeplata się z mrocznymi siłami, a granice między dobrem i złem nie zawsze są jednoznaczne. Głównym motywem jest zmaganie się z własnymi demonami, które są reprezentowane przez tytułowe \"cienie\". Hałas tworzy złożoną, mroczną atmosferę, w której bohaterowie muszą stawić czoła nie tylko fizycznym zagrożeniom, ale również własnym lękom i wątpliwościom. Opowiadanie porusza tematy władzy, odpowiedzialności oraz osobistej walki o to, kim się jest, a także o to, jak przeszłość kształtuje teraźniejszość.', 'uploads/677d3a3d15333_Krolestwo_i_jego_cienie.jpeg', 2016, '2025-01-07 14:29:17', 'uploads/677d3a3d155c3_Krolestwo_i_jego_cienie.pdf'),
(40, 'Piekielna ortografia', 'Aneta Jadowska', 'horror', 'Piekielna ortografia to pierwsza książka z serii o przygodach Alex, młodej dziewczyny, która odkrywa, że w jej żyłach płynie krew czarownicy. Aneta Jadowska łączy w tej powieści elementy urban fantasy z humorem i zagadkami, tworząc barwny świat pełen magii, niebezpieczeństw i osobistych zmagań bohaterki. Główna bohaterka, Alex, nie tylko musi zmierzyć się ze swoją nowo odkrytą tożsamością magiczną, ale także stawić czoła nieoczekiwanym wyzwaniom, które pojawiają się w jej życiu. W \"Piekielnej ortografii\" magia i codzienne życie przenikają się, tworząc interesującą i pełną przygód fabułę. Książka jest pełna emocji, zaskakujących zwrotów akcji oraz niepowtarzalnego humoru, który przyciąga czytelnika.', 'uploads/677d3aa0464c8_Piekielna_ortografia.png', 2017, '2025-01-07 14:30:56', 'uploads/677d3aa046686_Piekielna_ortografia.pdf'),
(41, 'Samotność', 'Jozef Karika', 'horror', 'Samotność to powieść autorstwa słowackiego pisarza Jozefa Kariki, która łączy w sobie elementy thrillera psychologicznego i sensacji. Książka opowiada historię mężczyzny, który po tragicznych wydarzeniach w swoim życiu zostaje zmuszony do zmierzenia się z własną samotnością. Karika przedstawia głęboko poruszający obraz bohatera, który boryka się z wewnętrznymi demonami, poczuciem winy i nieufnością wobec innych ludzi. Książka porusza tematy samotności, utraty bliskich, a także poszukiwania sensu życia w świecie pełnym zagrożeń i niepewności. W tle fabuły toczy się mroczna i pełna napięcia akcja, która wciąga czytelnika w nieustanne ściganie prawdy i konfrontację z własnymi lękami. Karika stawia pytania o granice między rzeczywistością a iluzją, a także o to, jak samotność kształtuje nasze życie.', 'uploads/677d3b9973a7f_Samotnosc.jpeg', 2018, '2025-01-07 14:35:05', 'uploads/677d3b9973e03_Samotnosc.pdf'),
(42, 'W krainie sylfów', 'Agnieszka Hałas', 'horror', 'W krainie sylfów to opowiadanie Agnieszki Hałas, które przenosi czytelnika do tajemniczego świata pełnego magii i niezwykłych istot. Główna bohaterka, młoda kobieta, trafia do krainy zamieszkałej przez sylfy – tajemnicze, eteryczne istoty związane z żywiołem powietrza. W tej niezwykłej rzeczywistości, gdzie magia i niebezpieczeństwo współistnieją, bohaterka musi stawić czoła zarówno wewnętrznym, jak i zewnętrznym konfliktom. Hałas w mistrzowski sposób łączy elementy baśni, fantasy i realizmu, tworząc wciągającą historię o poszukiwaniach siebie, odkrywaniu nowych światów i pokonywaniu własnych lęków. Opowiadanie pełne jest nie tylko magii, ale również głębokich refleksji na temat natury świata i ludzkich emocji.', 'uploads/677d3c1e9b259_W_krainie_sylfow.jpeg', 2016, '2025-01-07 14:37:18', 'uploads/677d3c1e9b590_W_krainie_sylfow.pdf'),
(43, 'Pamiętnik', 'Nicholas Sparks', 'romance', 'Pamiętnik to jedna z najbardziej znanych powieści Nicholasa Sparksa, która stała się także podstawą popularnego filmu o tym samym tytule. Książka opowiada poruszającą historię miłości Noah i Allie, pary, która zakochuje się w sobie w młodości, ale zostaje rozdzielona przez różne okoliczności. Po latach, kiedy oboje są już dorosłymi ludźmi, ich drogi znowu się spotykają. Allie jest zaręczona z innym mężczyzną, a Noah, mimo upływu lat, wciąż pamięta o swojej pierwszej miłości. Powieść pokazuje, jak silna może być miłość, która przetrwa próbę czasu, przeciwności losu i osobiste tragedie. Jest to historia o pamięci, tęsknocie i niewypowiedzianych słowach, a także o sile, jaką daje miłość, aby pokonać wszelkie trudności. Książka dotyka także tematów starzenia się, choroby i nieuchronności śmierci, ale przede wszystkim pokazuje, jak wielką rolę w życiu człowieka odgrywa miłość i wspomnienia.', 'uploads/677d3f91effd6_pamietnik-b-iext158088913.jpg', 1996, '2025-01-07 14:52:01', 'uploads/677d3f91f02dc_Nicholas Sparks - PamiÄtnik.pdf'),
(44, 'Fobia', 'Dawid Kain', 'horror', 'Fobia to thriller psychologiczny autorstwa Dawida Kaina, który wciąga czytelnika w świat lęków, tajemnic i niepokoju. Główny bohater, młody mężczyzna, zaczyna zmagać się z niepokojącymi zjawiskami, które zaczynają zagrażać jego zdrowiu psychicznemu. Każdy rozdział książki prowadzi do coraz większego napięcia, a lęki bohatera stają się coraz bardziej realne i zagrażające jego życiu. Fabuła Fobii skupia się na odkrywaniu przyczyn tych tajemniczych zdarzeń, które łączą się z traumatycznymi wspomnieniami i niepokojącymi doświadczeniami z przeszłości. Kain w swojej powieści umiejętnie wprowadza czytelnika w atmosferę niepewności, ukazując zmagania bohatera z własnymi lękami, które nieustannie zacierają granicę między rzeczywistością a iluzją. To książka pełna napięcia, zaskakujących zwrotów akcji i głęboko osadzona w psychologii postaci.', 'uploads/677d4039e3084_photo_2025-01-07_15-53-19.jpg', 2016, '2025-01-07 14:54:49', 'uploads/677d4039e338e_Dawid Kain - Fobia.pdf'),
(45, 'Gospodarka nie-wiedzy', 'Krzysztof Jan Konsztowicz', 'sci-fi', 'Gospodarka nie-wiedzy to książka Krzysztofa Jana Konsztowicza, która podejmuje temat współczesnej gospodarki, ale z perspektywy nieco mniej konwencjonalnej. Autor w swojej pracy analizuje zjawisko nie-wiedzy, czyli brak wiedzy, która nie jest równoznaczna z ignorancją, ale raczej z nieświadomością mechanizmów, które wpływają na funkcjonowanie gospodarki, polityki i społeczeństwa. Konsztowicz zwraca uwagę na to, jak brak pełnej wiedzy może kształtować decyzje, jakie podejmujemy zarówno na poziomie jednostkowym, jak i zbiorowym, a także jak brak zrozumienia skomplikowanych procesów może prowadzić do nieprzewidywalnych konsekwencji. W książce autor bada także, jak mechanizmy nie-wiedzy mogą wpływać na rynki, regulacje gospodarcze, a także na nasze życie codzienne. To praca, która zmusza do refleksji nad tym, jak postrzegamy świat i w jakim stopniu nasza niewiedza może determinować przyszłość.', 'uploads/677d418d4b405_gospodarka nie-wiedzy.jfif', 2012, '2025-01-07 15:00:29', 'uploads/677d418d4b6a5_Krzysztof Konsztowicz - Gospodarka nie-wiedzy.pdf'),
(46, 'Antybaśń', 'Damian Olszewski', 'sci-fi', 'Antybaśń to książka Damiana Olszewskiego, która w nietypowy sposób łączy literaturę z kinematografią, tworząc opowieść, która może być zarówno literacką, jak i filmową inspiracją. Jest to powieść, która przewraca klasyczne schematy baśniowe do góry nogami, oferując czytelnikowi odmienną perspektywę na znane motywy. Olszewski, zamiast opowiadać o tradycyjnych bohaterach, takich jak księżniczki, królowie czy dzielni rycerze, przedstawia „antybohaterów” w opowieści, która bawi się konwencją baśniowego świata. Książka stawia pytania o to, czym właściwie jest prawda, dobro i zło w kontekście współczesnego społeczeństwa, a także o to, jak nasze wyobrażenia o tych pojęciach wpływają na nasze życie. Antybaśń jest pełna ironii i dystansu do klasycznych opowieści, jednocześnie tworząc głęboki, ale często krytyczny obraz świata, który oglądamy na ekranach kinowych. Autor wplata w fabułę liczne odniesienia do kina, filmów i popkultury, sprawiając, że książka staje się swoistym komentarzem do współczesnej kultury masowej.', 'uploads/677d41d97ebda_antybasz. Literatura, kinematografia.jfif', 2017, '2025-01-07 15:01:45', 'uploads/677d41d97ef32_Damian Olszewski - Antybaśń. Literatura, kinematografia.pdf'),
(47, 'Krótka historia czasu', 'Stephen Hawking', 'sci-fi', 'Krótka historia czasu to książka autorstwa wybitnego fizyka Stephena Hawkinga, która w przystępny sposób wprowadza czytelnika w świat współczesnej kosmologii, badając fundamentalne zagadnienia związane z czasem, przestrzenią, wszechświatem oraz naturą rzeczywistości. Hawking omawia w niej teorię względności, kwantową teorię grawitacji oraz ewolucję wszechświata, starając się wyjaśnić, jak nauka może opisać początek i koniec wszechświata. Książka bada także kwestie związane z czarnymi dziurami, teorią strun, a także koncepcją \"teorii wszystkiego\", czyli uniwersalnej teorii, która mogłaby wyjaśnić wszystkie prawa rządzące wszechświatem. Chociaż temat jest niezwykle skomplikowany, Hawking stara się uczynić go dostępnym dla szerokiego kręgu czytelników, unikając nadmiernego używania trudnego żargonu naukowego. Krótka historia czasu jest jednym z najważniejszych dzieł popularyzujących współczesną fizykę teoretyczną i pozostaje jednym z najbardziej znanych tekstów, które wprowadziły wiele osób w fascynujący świat kosmologii.', 'uploads/677d42ffbef28_krotka-historia-czasu-b-iext159292461.jpg', 1988, '2025-01-07 15:06:39', 'uploads/677d42ffbf246_Hawking Stephen - Kro¦Бtka historia czasu. Od Wielkiego Wybuchu do czarnych dziur.pdf'),
(48, 'Pierwsze trzy minuty', 'Steven Weinberg', 'sci-fi', 'Pierwsze trzy minuty to klasyczne dzieło autorstwa Stevena Weinberga, które stanowi jedno z najważniejszych wprowadzeń do kosmologii współczesnej. Książka opisuje wydarzenia, które miały miejsce tuż po Wielkim Wybuchu, w pierwszych trzech minutach istnienia wszechświata, gdy temperatura i gęstość były ekstremalne, a warunki wciąż sprzyjały powstawaniu podstawowych składników materii. Weinberg wyjaśnia, jak doszło do powstania atomów, cząsteczek i innych elementów, które w dalszym czasie tworzyły gwiazdy, galaktyki i całe struktury we wszechświecie. W książce autor łączy szeroką wiedzę z zakresu fizyki, astronomii i kosmologii, tłumacząc złożone teorie w sposób przystępny, choć z zachowaniem ich naukowej precyzji. Pierwsze trzy minuty nie tylko przedstawiają powstanie wszechświata, ale także pokazują, jak rozwój teorii kosmologicznych zmienia naszą wiedzę o początkach czasu i przestrzeni. Jest to książka, która wprowadza czytelnika w jedno z najbardziej fascynujących zagadnień współczesnej nauki, czyli początek i ewolucję wszechświata.', 'uploads/677d439f4886b_1ooi6oi1y0z53.jpg', 1977, '2025-01-07 15:09:19', 'uploads/677d439f48ad2_Weinberg S - Pierwsze trzy minuty.pdf'),
(49, 'Piękno wszechświata', 'Brian Greene', 'sci-fi', 'Piękno wszechświata to książka autorstwa Briana Greene\'a, znanego fizyka teoretycznego i popularyzatora nauki, która zagłębia się w zawiłości współczesnej fizyki, koncentrując się na teorii strun. Greene w przystępny sposób przedstawia zaawansowane idee, które opisują fundamentalne składniki wszechświata oraz jego strukturę na poziomie kwantowym. Książka wprowadza czytelnika w świat teorii strun, które mają na celu połączenie dwóch wielkich teorii fizycznych – ogólnej teorii względności i mechaniki kwantowej – w jedną spójną teorię wszystkiego.\r\nW Pięknie wszechświata Greene stara się odpowiedzieć na pytania dotyczące natury przestrzeni, czasu i materii, badając możliwości istnienia więcej niż trzech wymiarów przestrzennych oraz dążenie do znalezienia jednego, unikalnego opisu fizycznej rzeczywistości. Autor omawia także zagadnienia takie jak czarne dziury, ewolucja wszechświata, a także znaczenie matematyki w zrozumieniu praw natury. Książka jest pełna pasji i zrozumienia dla skomplikowanych kwestii, ale równocześnie stara się być przystępna dla szerokiego kręgu czytelników, w tym tych, którzy nie mają głębszej wiedzy z zakresu fizyki.\r\nPiękno wszechświata to zarówno fascynująca podróż przez współczesną fizykę, jak i próba pokazania, jak matematyka i teoria strun mogą otworzyć drzwi do nowego zrozumienia najgłębszych tajemnic wszechświata.', 'uploads/677d4425afe35_piekno-wszechswiata-superstruny-ukryte-wymiary-i-poszukiwanie-teorii-ostatecznej-ebook-epub-b-iext136929524.jpg', 2004, '2025-01-07 15:11:33', 'uploads/677d4425b01c6_Greene Brian - PiA¦ИTЩkno Wszechswiata. Superstruny ukryte wymiary i poszukiwania teorii osta.pdf'),
(50, 'Antrakt', 'Arkadiusz Buczek', 'poezja', 'Antrakt to powieść autorstwa Arkadiusza Buczka, która porusza temat ludzkich relacji, poszukiwania sensu życia oraz radzenia sobie z osobistymi trudnościami. Fabuła książki skupia się na losach bohatera, który wkracza w okres swojego życia, w którym musi zmierzyć się z emocjonalnymi, społecznymi i psychologicznymi zawirowaniami. \"Antrakt\" to także opowieść o poszukiwaniu równowagi w świecie pełnym chaosu, o momentach zawahania i kryzysu, które każdemu z nas mogą się zdarzyć. Buczek zręcznie łączy elementy dramatu z refleksją filozoficzną, stawiając pytania o znaczenie czasu, samotności, spełnienia i nieustannych zmian w życiu. Książka ta jest również metaforą momentów zawieszenia, przerw w życiu, które w rzeczywistości bywają nieoczekiwanymi punktami przełomowymi. Autor wciąga czytelnika w głęboką, emocjonalną podróż, zmuszając do refleksji nad tym, co naprawdę ma znaczenie w życiu.', 'uploads/677d458585e41_antrakt.jfif', 2021, '2025-01-07 15:17:25', 'uploads/677d4585861c8_Arkadiusz Buczek - Antrakt.pdf'),
(51, 'Milimetry naszych serc', 'Kinga Michałowska', 'poezja', 'Milimetry naszych serc to powieść autorstwa Kingi Michałowskiej, która łączy w sobie elementy romansu i literatury obyczajowej. Książka opowiada historię dwojga ludzi, którzy muszą zmierzyć się z własnymi lękami, przeszłością i skomplikowanymi emocjami, by odnaleźć prawdziwą miłość. Bohaterowie, mimo początkowych trudności, zbliżają się do siebie powoli, stopniowo przełamując bariery, które zbudowali w wyniku wcześniejszych doświadczeń życiowych. Książka porusza temat intymności, zaufania i budowania relacji, w której najdrobniejsze gesty i decyzje mają ogromne znaczenie. Michałowska wplata w swoją opowieść refleksje na temat tego, jak małe rzeczy w życiu – te „milimetry naszych serc” – potrafią decydować o tym, czy jesteśmy w stanie otworzyć się na drugiego człowieka. Jest to pełna emocji, subtelna historia o miłości, o tym, jak bardzo może ona zmienić nasze życie, a także o tym, jak ważne są te chwile, które kształtują naszą bliskość z innymi.', 'uploads/677d45d079954_Milimetry naszych serc.jfif', 2022, '2025-01-07 15:18:40', 'uploads/677d45d079dbe_Kinga Michałowska - Milimetry naszych serc.pdf'),
(52, 'Boska komedia', 'Dante Alighieri', 'poezja', 'Boska komedia to jedno z najważniejszych dzieł literatury światowej, napisane przez włoskiego poetę Dantego Alighieriego. Jest to epicka poema, które opisuje podróż autora przez trzy krainy zaświatów: Piekło, Czyściec i Raj. Główna akcja toczy się w formie wędrówki Dantego, który po utracie ukochanej Beatrycze, zostaje prowadzone przez różne postacie. W tej podróży pomaga mu Wergiliusz, symboliczna postać rozumu i klasycznej mądrości, a potem Beatrycze, symboliczna postać boskiej miłości.\r\nBoska komedia jest nie tylko dziełem literackim, ale również głęboką refleksją filozoficzną, teologiczną i moralną. Dante w swojej wizji przedstawia zarówno społeczne, jak i religijne aspekty życia, ukazując ludzi, którzy zostali potępieni, oczyszczani lub zbawieni w zależności od ich uczynków na ziemi. Dzieło jest pełne alegorii, symboli i odniesień do średniowiecznej myśli religijnej oraz do ówczesnej polityki i kultury.\r\nBoska komedia ma także ogromne znaczenie dla rozwoju literatury i języka włoskiego, stanowiąc fundament dla późniejszych dzieł literackich. To również niezwykle ambitna wizja wszechświata, pełna poetyckich obrazów, która przez wieki inspiruje czytelników i badaczy na całym świecie.', 'uploads/677d468de9778_boska-komedia_MsFJuo1.jpg', 1320, '2025-01-07 15:21:49', 'uploads/677d468de9a19_Dante Alighieri - Boska Komedia.pdf'),
(53, 'Iliada', 'Homer', 'poezja', 'Iliada to jeden z najstarszych i najważniejszych utworów literatury zachodniej, przypisywany starożytnemu poecie Homerowi. Jest to epos, który opisuje wydarzenia związane z wojną trojańską, a konkretnie ostatnimi miesiącami tego konfliktu. Choć nie jest pełnym zapisem całej wojny, Iliada koncentruje się na bohaterskich czynach, dramatach i sporach pomiędzy najważniejszymi postaciami wojny, takimi jak Achilles, Hektor, Agamemnon, Priam i wielu innych.\r\nGłównym wątkiem jest konflikt pomiędzy Achillesem, największym wojownikiem Greków, a Agamemnonem, wodzem greckim, który odebrał Achillesowi jego zdobycz wojenną, co doprowadziło do gniewu Achillesa i jego wycofania się z walk. Ta decyzja ma poważne konsekwencje dla przebiegu wojny, a cała opowieść pełna jest tematów honoru, zemsty, lojalności, a także refleksji nad losem i śmiercią.\r\nIliada jest także dziełem pełnym interwencji bogów, którzy wpływają na losy ludzi, prowadząc ich do zwycięstw lub klęsk. Tekst jest nie tylko opowieścią o wojnie, ale także o ludzkich namiętnościach, ludzkich słabościach oraz walce z losem. To klasyczne dzieło literackie pozostaje fundamentem dla rozumienia kultury starożytnej Grecji oraz dla literatury eposu heroicznego.\r\n\r\n', 'uploads/677d472a3f93f_e_a07r.jpg', 0, '2025-01-07 15:24:26', 'uploads/677d472a3fcfb_homer-iliada.pdf'),
(54, 'Odyseja', 'Homer', 'poezja', 'Odyseja to jeden z najważniejszych eposów starożytnej Grecji, przypisywany Homerowi, który jest kontynuacją wydarzeń opisanych w Iliadzie. Akcja Odysei skupia się na powrocie Odyseusza, króla Itaki, do swojej ojczyzny po zakończeniu wojny trojańskiej. Jego podróż, która trwała aż 10 lat, jest pełna przygód, niebezpieczeństw oraz spotkań z mitologicznymi stworzeniami i bogami.\r\nGłównym wątkiem Odysei jest walka Odyseusza o powrót do domu, do żony Penelopy i syna Telemacha. W trakcie swojej podróży Odyseusz zmaga się z wieloma trudnościami, m.in. z cyklopem Polifemem, czarodziejką Kirke, sirenami czy władcą podziemi, Hadesem. Jednak największymi przeciwnikami są czas, własne pragnienie i pokusy, które utrudniają mu powrót.\r\nOdyseja jest nie tylko opowieścią o przygodach, ale także o mądrości, odwadze, sprycie oraz wytrwałości w dążeniu do celu. To także dzieło pełne wartości moralnych, pokazujące znaczenie lojalności, rodziny oraz honoru. Homer w Odysei ukazuje także złożoną relację między ludźmi a bogami, którzy mają ogromny wpływ na losy bohaterów.\r\nEpos ten jest fundamentem literatury epickiej i jednym z najważniejszych dzieł, które kształtowały całą tradycję literacką świata zachodniego.', 'uploads/677d479bc13bc_odyseja-b-iext130547761.jpg', 0, '2025-01-07 15:26:19', 'uploads/677d479bc16d1_Homer - Odyseja.pdf'),
(61, 'Elizium', 'Mike A. Clearance', 'fantasy', 'Książka „Elizium” autorstwa Mike’a A. Clearance’a to pierwszy tom trylogii zatytułowanej „Władcy Dusz”. Jest to debiutancka powieść autora, która łączy elementy mrocznego fantasy z psychologicznym thrillerem i duchową symboliką. Głównym bohaterem jest Jarmis Reggick, członek tajemniczego bractwa, który zmaga się z własną przeszłością i zawodami związanymi z rekrutami, których szkolił. Akcja rozgrywa się w fikcyjnym świecie Velfare, gdzie pojawia się postać zdająca się znać mroczne sekrety Jarmisa. Powieść eksploruje tematy winy, odkupienia i walki z wewnętrznymi demonami, osadzając je w bogato wykreowanym świecie pełnym nadprzyrodzonych elementów. Styl autora charakteryzuje się poetyckim językiem i głęboką refleksją nad ludzką naturą. „Elizium” to propozycja dla czytelników poszukujących literatury z pogranicza fantasy i psychologicznego dramatu, z silnym naciskiem na duchowość i introspekcję. Książka dostępna jest w formie e-booka, co ułatwia jej dostępność dla szerokiego grona odbiorców. Dla miłośników literatury, która skłania do przemyśleń i oferuje głębokie przeżycia emocjonalne, „Elizium” może okazać się wartościową lekturą.', 'uploads/683d8241dd4a0_677d168a9c1dc_okladka.jpg', 2016, '2025-06-02 10:47:33', '../uploads/683d81458aa94_677d168a9c761_Elizium - Mike A. Clearance.pdf');

-- --------------------------------------------------------

--
-- Структура таблиці `karty`
--

CREATE TABLE `karty` (
  `id_karta` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `numer_karty` varchar(20) NOT NULL,
  `waznosc` varchar(5) NOT NULL,
  `cvv` varchar(3) NOT NULL,
  `imie_nazwisko` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `karty`
--

INSERT INTO `karty` (`id_karta`, `id_user`, `numer_karty`, `waznosc`, `cvv`, `imie_nazwisko`) VALUES
(1, 3, '7658 4578 8399 5967', '02/27', '653', 'Nataliia Liashchenko');

-- --------------------------------------------------------

--
-- Структура таблиці `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `type` varchar(50) DEFAULT 'info'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`, `is_read`, `type`) VALUES
(4, 3, 'Nowa książka \"Elizium\" została dodana do biblioteki!', '2025-06-02 12:47:33', 0, 'info'),
(5, 4, 'Nowa książka \"Elizium\" została dodana do biblioteki!', '2025-06-02 12:47:33', 0, 'info'),
(6, 5, 'Nowa książka \"Elizium\" została dodana do biblioteki!', '2025-06-02 12:47:33', 0, 'info');

-- --------------------------------------------------------

--
-- Структура таблиці `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `reviews`
--

INSERT INTO `reviews` (`id_review`, `id_user`, `id_book`, `rating`, `created_at`, `comment`) VALUES
(1, 3, 33, 5, '2025-01-09 18:02:40', 'Bardzo fajna ksiązka'),
(10, 4, 33, 3, '2025-01-10 00:45:18', 'not bad'),
(11, 3, 28, 5, '2025-06-01 20:54:12', 'Fajno');

-- --------------------------------------------------------

--
-- Структура таблиці `sign_up`
--

CREATE TABLE `sign_up` (
  `id_user` int(11) NOT NULL,
  `fname` varchar(250) DEFAULT NULL,
  `lname` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `sign_up`
--

INSERT INTO `sign_up` (`id_user`, `fname`, `lname`, `address`, `email`, `password`, `status`, `created_at`, `profile_picture`) VALUES
(3, 'Nataliia', 'Liashchenko', 'ul. teatralna 25', 'admin1@gmail.com', 'admin123', 1, '2024-12-30 16:56:45', 'profile_683eec65bc4255.81445492.jpg'),
(4, 'Kateryna', 'Palii', 'ul. teatralna 25', 'Kateryna@gmail.com', 'kateryna123', 1, '2025-01-07 15:31:10', 'profile_683f43a755d6d1.10757601.jpg'),
(5, 'Nataliia', 'Liashchenko', 'ul. teatralna 25', 'o671520960@gmail.com', '$2y$10$lwldySrBvxVdYZln/8TI3uqfoVrZ.7hBtsn8/yBhk2EqD0OlbuXIS', 1, '2025-05-26 20:23:17', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `subscriptions`
--

CREATE TABLE `subscriptions` (
  `user_id` int(11) NOT NULL,
  `plan` varchar(20) NOT NULL,
  `subscribed_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `subscriptions`
--

INSERT INTO `subscriptions` (`user_id`, `plan`, `subscribed_at`) VALUES
(3, 'standard', '2025-06-04 15:35:20'),
(4, 'free', '2025-06-04 15:35:40');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_book` (`id_book`);

--
-- Індекси таблиці `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`);

--
-- Індекси таблиці `karty`
--
ALTER TABLE `karty`
  ADD PRIMARY KEY (`id_karta`),
  ADD KEY `id_user` (`id_user`);

--
-- Індекси таблиці `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `fk_reviews_user` (`id_user`),
  ADD KEY `fk_reviews_book` (`id_book`);

--
-- Індекси таблиці `sign_up`
--
ALTER TABLE `sign_up`
  ADD PRIMARY KEY (`id_user`);

--
-- Індекси таблиці `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблиці `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблиці `karty`
--
ALTER TABLE `karty`
  MODIFY `id_karta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблиці `sign_up`
--
ALTER TABLE `sign_up`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `archive`
--
ALTER TABLE `archive`
  ADD CONSTRAINT `archive_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `sign_up` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `archive_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `karty`
--
ALTER TABLE `karty`
  ADD CONSTRAINT `karty_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `sign_up` (`id_user`);

--
-- Обмеження зовнішнього ключа таблиці `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sign_up` (`id_user`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_book` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`),
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`id_user`) REFERENCES `sign_up` (`id_user`);

--
-- Обмеження зовнішнього ключа таблиці `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sign_up` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
