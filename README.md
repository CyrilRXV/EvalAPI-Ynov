API – Documentation

```
GET /api/products
```

## 🔍 1. Paramètres disponibles
| Paramètre      | Type  |                                     Description |
| :---        |:-----:|------------------------------------------------:|
| category      | string |        Filtre les produits par nom de catégorie |
| min_price   | float  |Filtre les produits dont le prix est ≥ min_price |
| max_price   | float  |Filtre les produits dont le prix est ≤ max_price |
| sort   | string  |Champ sur lequel trier (price, name, …) |
| direction   | string  |Sens du tri : asc ou desc |
| include   | string  |Relation(s) à inclure : category |
| limit   | integer  |Nombre de résultats par page (default: 20) |
| page   | integer  |Numéro de page pour la pagination Laravel |

➡️ Tous ces paramètres sont optionnels.

## 🌐 2. Exemple complet d’URL
```
GET /api/products?category=Electronics&min_price=50&max_price=200&sort=price&direction=asc&include=category&limit=10&page=2
```

## 🔎 3. Filtrage (Filter)
### Filtrer par catégorie
```
GET /api/products?category=Books
```

### Filtrer par prix minimum
```
GET /api/products?min_price=20
```

### Filtrer par prix maximum
```
GET /api/products?max_price=100
```

### Filtre combiné
```
GET /api/products?category=Books&min_price=10&max_price=50
```

## ↕️ 4. Tri (Sort)
Tri ascendant par prix
```
GET /api/products?sort=price&direction=asc
```

Tri descendant par nom
```
GET /api/products?sort=name&direction=desc
```

Si direction est omis → asc par défaut.

## 🔗 5. Relations conditionnelles (Include)

Permet de charger les relations uniquement si demandé.

Inclure la catégorie du produit
```
GET /api/products?include=category
```

Réponse :
```
{
"name": "Laptop",
"price": 999,
"category": {
    "id": 1,
    "name": "Electronics"
    }
}
```
Si include n’est PAS présent → la relation n’est pas chargée.

## 📄 6. Pagination

La pagination suit le système Laravel :

Limiter à 5 résultats :
```
GET /api/products?limit=5
```

Page 3 :
```
GET /api/products?page=3
```

## 🛠 7. Notes techniques

Ces paramètres sont traités via un ProductQueryBuilder et un ProductFilterDto :

filterByCategory()

filterByMinOrMaxPrice()

sortBy()

includeRelations()

## 🔑 8. 🔐 Authentification JWT
 * Access Token
    - envoyé dans le header Authorization
   - expire vite → 5 minutes

utilisé pour toutes les requêtes protégées
Authorization: Bearer <access_token>

* Refresh Token
    - stocké dans un cookie sécurisé
    - expire en 30 jours

renouvelé automatiquement
jamais envoyé dans le frontend → réduit les risques

Dans Laravel :
Cookie: refresh_token=<token>; 

## 🚪 9. Routes d’authentification


### POST /api/auth/login

```
Body :
{
"email": "user@example.com",
"password": "password"
}
```
```
Réponse :
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoidGVzdEBleGFtcGxlLmNvbSIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzY0ODkxNzk2LCJleHAiOjE3NjQ4OTIwOTZ9.BMxYEddL42mOrUwYu3pSJ2zmgGRyfdVrcyjxDyjo-S8",
    "refresh_token": "IYSFQ9hZwLZSpjHxkfESfof5v5zEMxuU3VE9gFhaSut8vPeSMSpQMhh5IaZV3Pn7",
    "message": "Successfully logged in"
}
```

### POST /api/auth/logout

```
### POST /api/auth/refresh
```

```
Réponse :
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoidGVzdEBleGFtcGxlLmNvbSIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzY0ODkxODU0LCJleHAiOjE3NjQ4OTIxNTR9.wlm5I1Mjr3b6Usb0mFoH_AV4yi6YAzebw0BS2j8mFhc",
    "refresh_token": "DWs3k5r4BuXgDTTkSojR956GRBc2hHmjqEipJ8sU8eweXcVrDeT0JIsrj7Fbbj9Q",
    "message": "Refresh token successfully"
}
```
