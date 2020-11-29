# EIS
Zadanie 1:
Znajdz błąd w zapytaniu: ( PostreSQL )

SELECT p.id, p.number, SUM(i.premium)
FROM policy p
RIGHT JOIN installment i ON i.policy_id = p.id
HAVING COUNT(i.id) > 1

ODP. Błąd jest w sekcji "HAVING COUNT(i.id) > 1", zamiast i.id powinno być i.policy_id


Napisza zapytania tworzące table do zapytania powyżej, które będą wydajne przy dużej licznie danych.

CREATE TABLE [IF NOT EXISTS] policy (
    id int PRIMARY_KEY,
    number int NOT NULL
);

CREATE TABLE [IF NOT EXISTS] installment (
    policy_id int PRIMARY_KEY,
    premium int NOT NULL
);


Zadanie 2:
Napisz prostą aplikację konsolową w jęzuku PHP której wynikiem będzie lista użytkowników zawierająca ("First Name", "Last Name", "Address") w formacie JSON oraz w formie wizualnej. 

Odp.
W celu uruchomienia należy w konsoli wpisać php bin/console user:list oraz podać argument, czyli ilosc wygenerowanych danych np.
 
 php bin/console user:list 10
 
 Dane w formacie JSON pojawią się pod tabelą.
 
 Zadanie 3:
 Stwórz widok HTML ( tabela ) którą będzie można posortować po kolumnach, dane do tabeli powinny być pobierane przez GET ( wykorzystaj kod z zadania 2 )
 
 Odp. Kod znajduje się w controllerze MainController.php