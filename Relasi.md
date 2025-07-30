### Tank Dealer

>**Tank Dealer** adalah sebuah web yang memudahkan militer untuk menjual dan membeli berbagai jenis **Tank**(walaupun saya hanya dapat membuat dari sisi admin panel saja, belom mampu dari sisi client panel), didalamnya **customer** dapat dengan mudah **memilih product tank dari setiap category**.

**Didalam category dapat menginput:**

- Nama Catgeory
- Status
  
**Disetiap product memiliki:**

- Nama product
- Category Product
- Price
- Stock
- Image
- Statusnya.

**Didalam Transaction Customer dapat menginput:**

- Nama Customer
- Nama Product
- Nama Category
- Quantity

#### Penjelasan Relasi:

- User memiliki hasOne ke customer, karena satu akun user hanya dimiliki 1 customer

- Category memiliki hasMany product, karena satu category dapat memiliki banyak product

- Category memiliki hasMany Transaction, karena satu category dapat terkait banyak transaksi

- Product memiliki belongsTo category, karena satu product hanya memiliki satu category

- Product memiliki hasMany transaction, karena satu product terdapat di beberapa transaction

- Transaction memiliki belongsTo ke customer, karena satu transaction hanya satu customer

- Transaction memiliki belongsTo ke category, karena satu transaction hanya satu customer

- Transaction memiliki belongsTo ke product, karena satu transaction hanya satu product
