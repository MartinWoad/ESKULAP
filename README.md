# ESKULAP


## Kontrola Wersji - czytaj więcej: [>>KLIK<<](docs/git_poradnik.md)
Aby coś wrzucić do repo, wykonujemy kilka kroków:
1. Sprawdzamy *status zmian*, przełączamy się na *mastera* i zaciągamy najnowsze *commity*:

```
git status -s
git checkout master
git pull
```

2. Tworzymy nowego *brancha*. Jeden branch = jedno zadanie jednej osoby

```
git checkout -b nazwa_nowego_brancha
```
3. Kodujemy co mamy zakodzić. 

4. Aby *wypchną*ć* zmiany, musimy dodać zmienione pliki do *"indeksu gita"*, stworzyć *"commita"* i go *"spushować"*

```
git add -A
git commit -m "Opis wprowadznych zmian"
git push
```

5. (opcjonalny) W przypadku, gdy jest to nowy branch, wyrzuci nam fatala. Musimy wtedy ustawić odpowiedni *"upstream"* na GitHubie dla tego brancha:

```
git push --set-upstream origin nazwa_nowego_brancha
```

6. *Eat, commit, sleep, repeat*. będąc na swoim branchu, punkty 3 i 4 możemy wykonywać wiele razy. Wtedy wypchniemy na niego kilka commitów. Zachęcam do tego, gdyż im większa liczba commitów, tym mniejsze prawdopodobieństwo *konfliktów* w *mergach*.


7. Gdy już wszystko zakodzimy i wypchniemy wszystkie commity, tworzymy **Pull Requesta** i dodajemy przynajmniej dwie osoby do **code review**. Czytaj więcej: [>>KLIK<<](docs/git_poradnik.md)

### GIT - Cheat sheet
- `git status` - wyświetla zmodyfikowane pliki oraz aktualny branch
- `git branch` - wyświetla aktualny branch i inne branche 


## Kod Strony
  Tu będziemy zajmować się kodem strony. Kod strony i wszystkie elementy z nim związane,
jak np. grafika przechowywane będą w folderze **_src_** i jego podfolderach.

## Dokumentacja Strony
  Tu będziemy zajmować się dokumentacją strony. Dokumentacja strony i wszystkie elementy z nią związane
przechowywane będą w folderze **_docs_** i jego podfolderach.

## Testowanie Strony
  Tu będziemy zajmować się testowaniem strony. Test case'y i wszystkie elementy z nimi związane
przechowywane będą w folderze **_test_** i jego podfolderach.
  
