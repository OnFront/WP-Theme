<?php

declare(strict_types=1);

namespace App\Service;

defined('ABSPATH') || exit;

class TranslateString
{
    public string $footerMIP = 'Mała Instytucja Płatnicza MIP42/2019';
    public string $footerCompany = 'PayEye Sp. z o.o. jest wpisana do rejestru przedsiębiorców KRS prowadzonego przez Sąd Rejonowy dla Wrocławia – Fabrycznej we Wrocławiu, VI Wydział Gospodarczy KRS, pod numerem KRS: 0000773560, NIP: 894-313-88-45, REGON: 382724489 Siedziba: ul. Zwycięska 43, 53-033 Wrocław';
    public string $footerCopyright = 'Copyright by PayEye 2022. All rights reserved.';

    public string $menuJoinUs = 'Dołącz teraz!';
    public string $menuJoinUsPartner = 'Zostań partnerem!';

    public string $client = 'Klient';
    public string $partner = 'Biznes';

    public string $buttonFindOutMore = 'Dowiedz się więcej';
    public string $buttonSeeVideo = 'Zobacz wideo';
    public string $buttonReadMore = 'Czytaj więcej';
    public string $buttonSeeMore = 'Zobacz więcej';
    public string $buttonSeeLess = 'Zobacz mniej';

    public string $mapSearch = 'Wyszukaj miejsce';

    public string $postShare = 'Udostępnij wpis';

    public string $back = 'Powrót';
    public string $categories = 'Kategorie';
    public string $category = 'Kategoria';

    public string $termsAll = 'Wszystkie';

    public string $searchFormPlaceholder = 'Wyszukaj';

    public string $formAddFile = 'Dodaj załącznik';

    public string $mediaMedium = 'Tytuł';
    public string $mediaSearch = 'Wybierz lub wyszukaj';
    public string $mediaSelectedForYou = 'Wybrane dla Ciebie:';
    public string $mediaAll = 'Wszystkie:';

    public string $listPartners = 'Lista partnerów';
    public string $listPartnersCategory = 'Wybierz kategorię';
    public string $listPartnersPoints = 'Punkty PayEye';
    public string $listPartnersSeePromo = 'promocja';
    public string $listPartnersCheckboxSeePromo = 'Promocje';

    public string $mobileDownloadApp = 'Pobierz aplikację!';

    public string $cookieText = 'Ta strona używa ciasteczek w celach statystycznych i analitycznych. Dalsze korzystanie ze strony oznacza, że zgadzasz się na ich użycie.';
    public string $cookieProject = 'Projekt współfinansowany';
    public string $cookieButton = 'Akceptuję wszystkie';
    public string $cookieManager = 'Zarządzaj cookies';

    public string $cookieModalHeader = 'Polityka cookies';
    public string $cookieModalRejectAll = 'Odrzuć opcjonalne';
    public string $cookieModalAcceptAll = 'Akceptuję wszystkie';
    public string $cookieModalHeaderPreference = 'Zarządzaj preferencjami';
    public string $cookieModalAnalyticsCookie = 'Analityczne pliki cookies';
    public string $cookieModalAdsCookie = 'Reklamowe pliki cookies';
    public string $cookieModalRequiredCookie = 'Niezbędne pliki cookies';
    public string $cookieModalAlwaysOn = 'Zawsze aktywne';
    public string $cookieModalSave = 'Zapisz i zamknij';
    public string $cookieAnalytical = 'Umożliwiają zbieranie danych analitycznych, czyli liczenie odsłon i ruchu na stronie www, co pozwala ocenić i usprawnić jej działanie. Mogą pochodzić od nas lub od naszych usługodawców. Dzięki nim dowiadujemy się, które strony www są najbardziej i najmniej popularne i widzimy, jak odwiedzający poruszają się po naszej stronie.';
    public string $cookieNecessary = 'Są to cookies, bez których strona www nie będzie działała; nie da się ich wyłączyć. Zwykle używa się ich w odpowiedzi na czynności wykonywane przez użytkownika strony www, wymagających od nas podjęcia pewnych działań - takich jak zmiana ustawień prywatności czy wypełnienie formularza.';
    public string $cookieAds = 'Reklamowe pliki cookie pozwalają na dopasowanie wyświetlanych treści reklamowych do Twoich zainteresowań, nie tylko na naszej witrynie, ale też poza nią. Mogą być instalowane przez partnerów reklamowych za pośrednictwem naszej strony internetowej. Służą im do budowania profilu zainteresowań użytkownika i przedstawiania mu odpowiednich reklam w czasie odwiedzin na innych stronach www.';

    public string $page404Header = 'Upss! Na <span>nasze oko</span> coś poszło nie tak';
    public string $page404Text = 'Błąd 404 - Nie znaleziono strony';
    public string $page404Btn = 'Wróc do strony głównej';

    public string $searchHeading = 'Wyniki <span>wyszukiwania</span>';
    public string $searchFound = 'Znaleziono';
    public string $searchFoundPart2 = 'wyników dla frazy';

    public string $faqSearchQuestion = 'Wyszukaj pytanie...';

    public string $sliderNewsSeePromo = 'zobacz promocję';

    public string $promoSeeOnMap = 'Zobacz na mapie';
    public string $promoSelectCategory = 'Wybierz kategorię';

    public string $comingSoonBusiness = 'Dla biznesu';
    public string $comingSoonClient = 'Dla klienta';

    public string $questionCard = 'Czy ta odpowiedź jest przydatna?';
    public string $questionCardButton = 'Przydatne!';

    public string $questionSearchQuestion = 'Wyszukaj pytanie';
    public string $questionSearch = 'Szukaj';
    public string $questionSortBy = 'Sortuj według';
    public string $questionSortDESC = 'Popularność: największa';
    public string $questionSortASC = 'Popularność: najmniejsza';

    public string $days = 'Dni';
    public string $hours = 'Godzin';
    public string $minutes = 'Minut';
    public string $seconds = 'Sekund';

    // V2
    public string $joinToPayEye = 'Dołącz do PayEye';
    public string $mapPointsLocation = 'Szukaj punktów PayEye według kategorii';
    public string $mapPointsSearchHeader = 'Znajdź punkt PayEye';
    public string $mapPointsCountFilter = 'Filtry: zaznaczono';
    public string $mapPointsAllPoints = 'Wszystkie punkty';
    public string $postPrev = "Poprzedni";
    public string $postNext = 'Następny';
    public string $monthly = 'miesięcznie';
    public string $applyFilters = 'Zastosuj filtry';
    public string $typeNamePoint = 'Wpisz nazwę punktu';
    public string $navigate = 'Nawiguj';
    public string $mapPointsNotResult = 'Nie znaleźliśmy takiego punktu.';

    public string $locationWithPayEye = 'Miejsca z PayEye';
    public string $discountWithPayEye = 'Promocje';
    public string $promotionBigSix = 'Wielka 6';
}
