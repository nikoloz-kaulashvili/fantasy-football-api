FANTASY FOOTBALL API
აღწერა, არქიტექტურა და განხორციელებული ფუნქციონალი

1) სისტემის მიმოხილვა:

Fantasy Football REST API შექმნილია Laravel 12-ის გამოყენებით და მუშაობს Laravel Sanctum.
სისტემა მომხმარებელს აძლევს შესაძლებლობას დარეგისტრირდეს, მიიღოს ავტომატურად გენერირებული გუნდი, მართოს საკუთარი ფეხბურთელები, 
გაყიდოს მოთამაშეები სატრანსფერო ბაზარზე და შეიძინოს სხვა მოთამაშეები. პროექტი ორენოვანია.

2) ავტენტიფიკაცია:

სისტემაში იყენებს რეგისტრაცია, ავტორიზაცია, logout და დაცული API endpoint-ებს. ავტორიზაცია ხორციელდება Sanctum გამოყენებით.
რეგისტრაციის პროცესში ავტომატურად იქმნება გუნდი და გენერირდება 20 ფეხბურთელი. ასევე გუნდ ენიჭება საწყისი ხუთ მილიონი ბიუჯეტი.

3) გუნდის ავტომატური გენერაცია:

რეგისტრაციის შემდეგ სისტემა ქმნის სამ მეკარეს, ექვს მცველს, ექვს ნახევარმცველს და ხუთ თავდამსხმელს. თითოეულ ფეხბურთელს აქვს შემთხვევითი სახელი, გვარი და ქვეყანა.(ორენოვანი) 
ასაკი განისაზღვრება თვრამეტიდან ორმოც წლამდე. საწყისი საბაზრო ღირებულება არის ერთი მილიონი დოლარი.

4) გუნდის მართვა:

მომხმარებელს შეუძლია საკუთარი გუნდის სრული ინფორმაციის ნახვა. შესაძლებელია გუნდის სახელისა და ქვეყნის შეცვლა (ორენოვანი). 
შესაძლებელია მოთამაშეების შეცვლა ძირითადიდან სათადარიგოზე და პირიქით.

5) ფეხბურთელის მართვა:

მომხმარებელს შეუძლია შეცვალოს ფეხბურთელის სახელი, გვარი და ქვეყანა (ორენოვანი). 
ყველა მოქმედება კონტროლდება autorization policy, რაც უზრუნველყოფს უსაფრთხოებას.

6) სატრანსფერო ბაზარი:

სისტემა საშუალებას აძლევს მომხმარებელს გამოიტანოს ფეხბურთელი გასაყიდად ტრანსფერ მარკეტზე, ნახოს საჯარო ბაზარი და შეიძინოს სხვა გუნდის ფეხბურთელი. 
წარმატებული ტრანსფერის შემდეგ მყიდველის ბიუჯეტი მცირდება, გამყიდველის ბიუჯეტი იზრდება და ფეხბურთელის საბაზრო ღირებულება იზრდება შემთხვევითად ათიდან ას პროცენტამდე.

7) არქიტექტურის აღწერა:

პროექტში გამოყენებულია Service Layer მიდგომა, სადაც ბიზნეს ლოგიკა გამოყოფილია Controller-ებიდან. გამოყენებულია Policy ავტორიზაცია. ტრანსფერები რეალიზებულია transaction script პრინციპით. 
ობიექტების გენერაციაში გამოყენებულია Factory მიდგომა. ორენოვანი ველები ინახება JSON ფორმატში. ყველა API პასუხი დაბრუნდება ერთიანი JSON სტრუქტურით.რქიტექტურა და დიზაინ პატერნები
პროექტი აგებულია შრეებად დაყოფილ არქიტექტურაზე და მიყვება Laravel-ის საუკეთესო პრაქტიკებს.
გამოყენებულია Service Layer, სადაც ბიზნეს ლოგიკა გამიჯნულია Controller-ებიდან და განთავსებულია ცალკე სერვის კლასებში. ეს ზრდის კოდის სისუფთავეს და ტესტირებადობას.
გამოყენებულია Factory Pattern მოთამაშეების გენერაციისა და ტესტირების მონაცემების შესაქმნელად. მონაცემთა საწყისი შევსებისთვის გამოყენებულია Seeders.
ტრანსფერების დროს გამოყენებულია Database Transactions და Row Level Locking, რაც უზრუნველყოფს მონაცემთა კონსისტენტურობას და თავიდან აცილებს ერთდროულ ორმაგ შეძენას.
ავტენტიფიკაცია რეალიზებულია Laravel Sanctum-ის გამოყენებით, ხოლო ავტორიზაცია კონტროლდება Policy კლასებით.
API პასუხები სტანდარტიზებულია API Resource-ების საშუალებით და ბრუნდება ერთიანი JSON სტრუქტურით.
გამოყენებულია Feature Testing კრიტიკული სცენარების შესამოწმებლად, მათ შორის რეგისტრაცია, ავტორიზაცია და ტრანსფერები.
პროექტი იყენებს Localization მექანიზმს ქართულ და ინგლისურ ენაზე მხარდაჭერისთვის.
დამატებით დანერგილია გლობალური ლოგირება, სადაც სისტემის მნიშვნელოვანი ქმედებები ინახება როგორც წარმატებული, ასევე წარუმატებელი ოპერაციების შემთხვევაში. ეს ზრდის მონიტორინგისა და დებაგინგის შესაძლებლობას.
სატრანსფერო ბაზრის listing-ების შემთხვევაში გამოყენებულია ლოკალური ქეშირება, რაც ამცირებს მონაცემთა ბაზაზე დატვირთვას და ზრდის API-ის მუშაობის სისწრაფეს.
მონაცემთა ბაზის დონეზე გამოყენებულია ინდექსირება კრიტიკულ ველებზე წარმადობის გასაუმჯობესებლად. ასევე ცხრილები ერთმანეთთან დაკავშირებულია foreign key-ების საშუალებით, 
რაც უზრუნველყოფს რეფერენციული მთლიანობის დაცვას და მონაცემთა კონსისტენტურობას.

-----------------------------------------------------------------------------------------------

ინსტალაცია:

1) git clone https://github.com/nikoloz-kaulashvili/fantasy-football-api.git

2) შემდეგ გადადით პროექტის ფოლდერში
cd fantasy-football-api

3) composer install

4) დააკოპირეთ .env.example და შეუცვალეთ სახელი ->.env

5) php artisan key:generate

6) php artisan queue:table

7) php artisan migrate

8) php artisan db:seed

user:admin@fantasy.ge
password:12345678

9) php artisan serve

10) php artisan test

ამის შემდეგ API ხელმისაწვდომი იქნება მისამართზე
http://127.0.0.1:8000/api/v1

-----------------------------------------------------------------------------------------------

Documentation:
postmen url : https://orange-equinox-259372.postman.co/workspace/My-Workspace~7b3150f6-d80a-475b-84c7-fb4e0d38c210/collection/30145677-a7a87419-59dc-4a51-8e31-3eafdf9cf903?action=share&source=copy-link&creator=30145677

URL:http://127.0.0.1:8000/api/v1/
Authorization : bearer-token

1) Registration

POST /register

Headers:
Content-Type: application/json
Accept: application/json

Fields:
name (string, required)
email (string, required, unique)
password (string, required, min:6)
password_confirmation (string, required, must match password)

2) Login

POST /login

Headers:
Content-Type: application/json
Accept: application/json

Fields:
email (string, required)
password (string, required)

3) Logout

POST /logout

Headers:
Accept: application/json
Authorization: Bearer {token}

Fields:
—

4) Create Market Listing

POST /market/listings

Headers:
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}

Fields:
player_id (integer, required, must belong to authenticated user's team)
price (integer, required, min:1)


5) Buy Market Listing

POST /market/listings/{id}/buy

Headers:
Accept: application/json
Authorization: Bearer {token}

Fields:
—

6) Swap Players

POST /team/swap

Headers:
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}

Fields:
in_player_id (integer, required, must belong to authenticated user's team, bench player)
out_player_id (integer, required, must belong to authenticated user's team, starter player)

7) Update Team

PUT /team

Headers:
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}

Fields:
name.en (string, required)
name.ka (string, required)
country.en (string, required)
country.ka (string, required)

8) Update Player

PUT /players/{id}

Headers:
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}

Fields:
first_name.en (string, required)
first_name.ka (string, required)
last_name.en (string, required)
last_name.ka (string, required)
country.en (string, required)
country.ka (string, required)

9) Update Market Listing

PUT /market/listings/{id}

Headers:
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}

Fields:
player_id (integer, required, must belong to authenticated user's team)
price (integer, required, min:1) // $

10) Get Market Listings

GET /market/listings

Headers:
Accept: application/json
Authorization: Bearer {token}

Fields:
—

11) Get My Team

GET /team

Headers:
Accept: application/json
Authorization: Bearer {token}

Fields:
—

12) Get My Transfers

GET /my-transfers

Headers:
Accept: application/json
Authorization: Bearer {token}

Fields:
—
