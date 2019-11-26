# RentCar
 Završni rad za kurs iz PHP-programiranja

 Ovaj projekat je pravljen kao završni rad posle šesto-mesečnog kursa iz PHP programiranja. U projektu su uključene sve glavne tehnologije koje su obradjene tokom samog kursa: HTML, CSS, Java Script i PHP preko framework-a Laravel. 

 Tema projekta je uprošćeni primer jedne RentCar agencije. Agencija za koju je radjen sajt, ima jednu jedinstvenu lokaciju za izdavanje i vraćanje automobila, ne daje posne opcije preko sajta i sve novčane transakcije se vrše na licu mesta. Ovaj projekat ima isključivu školsku svrhu i nije predvidjen za stvarne aplikacije. 

Opis tehnologija

Najveći deo rada je uradjen uz pomoć Laravel-a, koji je framework PHP-a. Sav HTML je upisan u Laravel-ov blade. Stranice su uniformisane i imaju header i footer. Većina formi direktno pozivaju controler preko ruta i vode do preodredjene stranice. Deo poziva ka bazi je uradjen uz pomoć DB modela, preko raw SQL-a, a drugi deo preko Laravel Eloquent-a sa posebnim modelom za svaku tabelu. Upotrebljene su i transakcije. Login je izveden preko Laravel-ovih igradjenih metoda, a ovlašćenja za različite tipove korisnika, su regulisana preko middlewere-a koji su prikačeni na rute. 
Front end deo za rezervacije je uradjen na dva načina: uz pomoć vanile Java Script-a, koji preko fetch API-ja poziva server, i onda dinamički pravi kartice sa automobilima i preko Vue-a koji koristi isti fetch API. Forma koja produžava rezervacije takodje koristi fetch API. JS je korišćen za filter tabela, za ,,Da li ste sigurni" modul, i za druge pogodne operacije. U CSS-u je uglavnom korišćena Flex tehnologija. Animacije i padajući meniji su takodje uradjene preko CSS-a.  
Kao tekt editor je korišćen Visual Studio Code sa sledećim ekstenzijama: PHP Intelphense, PHP IntelliSense, Laravel Blade Snippets, Laravl Blade Spacer...

Opis Baze

Baza se sastoji od 9 tabela, od kojih su 4 deo Laravel-ovog Login-a, i 3 od njih nisu modifikovane ni na jedan način. Tabele koje nisu deo Laravel-ovog logina su napravljanje uz pomoć phpmyadmin-a.

-U tabeli model su opisani tipovi (modeli) automobila [ime modela, klasa, tip menjača, broj sedišta, broj vrata, broj torbi, slika].
-U tabeli cenovnik su opisane cene za svaki tip automobila pojedinačno [ID, model, maksimalni broj dana, cena po danu].
-U tabeli automobli su upisani pojedinačni automobili sa svojim podacima [broj šasije, broj saobraćajne dozvole, broj registarskih tablica, model, godina proizvodnje, predjena kilometraža, datum važenja registracije, kilometraža na kojoj su radjeni mali i veliki servis, da li je aktivan, da li je na servisu].
-U tabeli rezervacije su upisane rezervacije automobila kako za mušterije tako i za potrebe servisiranja [ID rezervacije, ID vozila, Ime kupca, email, broj telefona, datum početka, datum završetka, cena, napomena].
-U tabeli servisna knjižica se čuvaju podaci o servisiranju automobila [ID, ID automobila, datum, kilometraža, tip servisa, opis]. 
-U tabeli users su dodati telefon i role. 

Opis Kontrolora

ReservationController je zadužen za modifokovanje rezervacija (produženje ili skraćenje), otkazivanje rezervacija, kao i za njihovo prikazivanje po više kriterijuma.
CarInfoController je zadužen za praćenje kritičnih automobila (onima kojima treba servis), zakazivanje servisa, i za pravljenje stranica sa spiskom automobila.
ServiseController je zadužen za stranice o servisu, i vodjenje servisne knjižice. 
BookingController je zadužen za kreiranje rezervacije sa FE strane. 
AdminController je zadužen za odredjivanje uloga korisnicima, za brisanje korisnika, i dodatno dodavanje slika. 
TipoviAutomobilaVontroller je zadužen za dodavanje i izmenu tipova (modela) automobila za adminstratore, gde je uključeno i kreiranje cenovnika.
CarController je zadužen za dodavanje i izmenu automobila za administratore. 
FrontPageController je zadužen za pozivanje front end stranica koje nemaju veze sa bazom. 
Laravel takodje ima više sopstvenih ugradjenih controllera. 

Tipovi korisnika

1. Neregitrovani korisnik,
2. Registrovani korisnik,
3. Zaposleni,
4. Administrator,
5. Super Administrator. 

Ovlašćenja tipova korisnika su ograničena Laravelovim ugradjenim funkcijama i middleware metodom koja je dodatno definisana. 

Funkcionalnosti sajta

-Neregistrovani korisnik

1. Neregistrovani korisnik može da rezerviše vozilo. Prvo bira vremenski period, a onda vrši rezervaciju jednog od ponuđenih modela.
2. Može da pristupi stranici sa spiskom modela i cenom za svaki. 
3. Može da pristupi drugim stranicama sajta koje su otvorene za javnost.

-Registrovani korisnik (role 0)

Osim toga što može da uradi sve i što može neregistrovani korisnik,

1. Može da menja sopstevne podatke, username, email adresu i broj telefona. 
2. U formi za rezervaciju predhodna 3 podatka su već upisana iz baze. 
3. Druge funkcijonalnosti koje daje Laravel registrovanim korisnicima. 

-Zaposleni (role 1-9)

Osim svih stvari koje mogu da urade i predhodne kategorije:

1. Ima pristup admin panelu.
2. Ima pristup tabeli sa automobilima koji su kritični (kojima ističe registracije i koji bi trebali da idu na mali ili veliki servis)
3. Ima pristup spisku aktivnih automobila.
4. Ima pristup spisku rezervacija. 
5. Može da zakaže servis automobilima.
6. Može da dodaje kilometražu automobilima. 
7. Može da upisuje servis u servisnu knjižicu.
8. Može da upisuje produženje registracije. 
9. Može da otkaže servis.
10. Može da otkaže rezervacije koje nisu još započele (ukoliko nije prošlo 3 dana).
11. Ima pristup filteru za tabele, i filteru za rezervacije. 
12. Može da produži ili skrati rezervaciju. 

-Adminstrator (role 10-99)

Osim svih stvari koje mogu da urade i predhodne kategorije:

1. Ima pristup posebnom delu menija.
2. Ima pristup spisku svim korisnicima.
3. Može da postavlja uloge korisnicima (osim uloge Super Administratora).
4. Može da obriše korisnika.
5. Ima pristup spisku neaktivnih automobila.  
6. Može da dodaje i modifikuje modele u potpunosti.
7. Može da dodaje i modfikuje automobile u potpunosti, uključujući da ih deaktivira.
8. Može da dodaje slike na serveru (kako bi se zamenile slike modela). 
9. Ima pristup širem spisku modela, koji uključuju i one koji nisu aktivni (koji nemaju nijedan aktivan automobil).

-Super Adminstrator (role 100)

Osim svih stvari koje mogu da urade i predhodne kategorije:

Super Administrator nema nijednu dodatnu funkcijanost, ali njegova uloga se ne može promeniti i on se ne može obrisati. 