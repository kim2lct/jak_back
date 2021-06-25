# Back End App

This laravel apps just for fun and testing , 
download and try it. :) 

## Instalation
- download .zip from github & extract ke htdocs masing-masing web server
- run __composer install__
- run __npm install && npm run dev__
- Rename __env.example to .env__
- run __php artisan key:generate && php artisan migrate --seed__ 
- run __php artisan serve"__

### Route
/api/login
/api/register
/api/logout
/api/product
/api/product/{id} :show
/api/product/{id} :update
/api/product/{id} :delete

### Flow

Ini hanya bersifat sebagai *backend* jadi setelah server up maka anda boleh memasukan data-data lewat posman atau front end
**default login user**
=====================
email:admin@mail.com
pass:adminku
setelah login anda akan mendapatkan *_token* jika memakai __postman atau yang lain__ kecuali front end karena token akan disimpan didalam __session__ setelah login , dan token tersebut digunakan untuk mengakses beberapa route yang terproteksi, jika anda ingin register user baru anda boleh masuk route register , jika data telah sesuai maka user baru akan ditambahkan kedalam database anda

untuk membuat produk baru anda boleh masukan route product dan tokennya ,lalu masukkan data jika data yang anda masukan valid , maka product akan terbuat di database.

user biasa tidak bisa membuat, mengupdate , dan mendelete product pastikan anda menggunakan user id:1 untuk membuat product

untuk edit anda boleh masukan route edit , masukkan valid data maka product akan terupdate di database

untuk delete anda boleh masukan route delete maka product yang anda buat akan terhapus.

note: semua route terproteksi oleh auth:middleware kecuali login,register,view product,dan all product.

Terima kasih
*kim2lct*
Have a nice day