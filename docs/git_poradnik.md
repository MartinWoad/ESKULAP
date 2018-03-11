 # git i GitHub - mini poradnik
 
 ### Tutaj pozostaje jeszcze wszystko do dopisania


  Trzeba ograniczyć prawdopodobieństwo wrzucania commitów, które rozwalą cały projekt.
Każda funkcjonalność ma być robiona na osobnych branchach (tzn 1 branch = 1
zadanie 1 osoby). Po wrzuceniu kodu i sprawdzeniu, osoba robiąca dane zadanie robi tzw. „Pull
Request” i przypisuje do niego np. 2 inne osoby w celu wykonania przez nie „Code review”. Code
review polega na: przejrzeniu kodu (czy nie ma tam ukrytych „bomb”, czy funkcje i zmienne
nazywają się w miarę ok, czy kod jest napisany jak w konwencji nakazano) oraz przetestowaniu tego
(czyli po prostu odpaleniu danej podstronki, przeklikanie czy działa i czy nie wywala całego systemu).
Gdy wszystko jest ok, osoby robiące code review klikają w przycisk „Approve” i wtedy osoba
odpowiedzialna za dane zadanie ma wykonać merge do głównego brancha.
Dzięki temu na głównym branchu mamy cały czas działający projekt, bez rozwalonych kawałków
funkcjonalności, gotowy do pokazania „klyentowi”.
Z kolei robienie Code Review uchroni nas przed zjawiskiem „ciągle nie działającego projektu”
(który na dłuższą metę zniechęca wszystkich) oraz inni mogliby zobaczyć co zostało już napisane,
będzie większa wymiana wiedzy (zawsze można coś fajnego podpatrzyć podczas robienia code
review).
  Odnośnie samych kwestii technicznych – czy mielibyśmy tylko branch master, i wszyscy by się
„odbranchowali” od niego i do niego mergowali, czy dodatkowo wprowadzilibyśmy drugi branch
develop, a mastera trzymali tylko do pokazowych wersji, to już zależy tylko od nas.