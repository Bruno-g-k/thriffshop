# Exemplo — Paginação Manual no Laravel

# Controller

```php
public function index(Request $request)
{
    $perPage = 10;

    $page = $request->get('page', 1);

    $total = Product::count();

    $products = Product::with('type')
        ->skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get();

    $lastPage = ceil($total / $perPage);

    return view('products.index', compact(
        'products',
        'page',
        'lastPage'
    ));
}
```

---

# Explicação

```php
$page = $request->get('page', 1);
```

Obtém a página atual pela URL.

Exemplo:

```txt
/products?page=2
```

---

```php
skip(($page - 1) * $perPage)
```

Define quantos registros serão ignorados.

Exemplo:

```txt
Página 1 → pula 0
Página 2 → pula 10
Página 3 → pula 20
```

---

```php
take($perPage)
```

Define quantos registros serão buscados.

---

# View Blade

```blade
<table>
   ...
</table>

<div class="mt-6 flex gap-2">

    @if($page > 1)

        <a href="?page={{ $page - 1 }}">
            Anterior
        </a>

    @endif

    @for($i = 1; $i <= $lastPage; $i++)

        <a href="?page={{ $i }}"
           class="{{ $page == $i ? 'font-bold underline' : '' }}">

            {{ $i }}

        </a>

    @endfor

    @if($page < $lastPage)

        <a href="?page={{ $page + 1 }}">
            Próximo
        </a>

    @endif

</div>
```

---

# SQL gerado conceitualmente

```sql
SELECT * FROM products
LIMIT 10 OFFSET 0;
```

---

# Comparação com Laravel

## Manual

```php
skip(...)
take(...)
```

---

## Laravel

```php
Product::paginate(10);
```

---

# Paginação automática do Laravel

```blade
{{ $products->links() }}
```