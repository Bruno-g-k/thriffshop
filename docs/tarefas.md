# Tarefas para Sprint Simulada - Projeto Loja Virtual

Objetivo da atividade: cada dupla deve criar uma branch, implementar uma tarefa pequena, fazer commit, push e abrir um Pull Request para revisão. As tarefas abaixo foram pensadas para alterar poucos arquivos, simulando demandas reais de uma sprint de desenvolvimento.

> Sugestão de padrão para branch: `feature/nome-da-tarefa`, `bugfix/nome-da-correcao` ou `refactor/nome-da-melhoria`.

---

## 1. Feature: Adicionar campo “marca” no cadastro de produtos

O cliente solicitou que cada produto tenha uma marca cadastrada. Adicione o campo `brand` na tabela de produtos por migration e ajuste o formulário de cadastro para permitir informar a marca. O campo pode ser opcional neste primeiro momento. Atualize também o Model `Product` para aceitar o novo campo em criação/alteração.

Arquivos prováveis: migration nova, `app/Models/Product.php`, `resources/views/products/create.blade.php`.

Obs.: não precisa aparecer esse campo na listagem em `index.blade.php`

---

## 2. Feature: Criar página pública de contato

Crie uma tela pública simples de contato da loja, sem necessidade de login. A página deve ter título, texto institucional curto e informações fictícias como e-mail, telefone e endereço. Adicione uma rota `/contato` apontando para essa view.

Arquivos prováveis: `routes/web.php`, `resources/views/contact.blade.php`.

---

## 3. Feature: Adicionar contador de produtos no Dashboard

A tela de dashboard ainda mostra apenas a mensagem padrão do Breeze. Altere o dashboard para exibir a quantidade total de produtos cadastrados. A informação pode ser passada por uma rota closure ou por controller simples, mantendo a alteração pequena.

Arquivos prováveis: `routes/web.php`, `resources/views/dashboard.blade.php`.

---

## 4. Bugfix: Tratar produto inexistente na edição

O cliente relatou erro ao acessar manualmente uma URL como `/products/update/999`. Hoje o sistema pode tentar abrir a tela com produto inexistente. Ajuste o método de edição para tratar quando o produto não for encontrado e redirecionar para a listagem com mensagem amigável.

Arquivos prováveis: `app/Http/Controllers/ProductsController.php`, `resources/views/products/index.blade.php`.

---

## 5. Bugfix: Tratar erro ao excluir produto

O cliente informou que, em alguns casos, ao excluir um produto, aparece uma tela de erro técnica. Adicione tratamento com `try/catch` no método de exclusão. Em caso de falha, registre o erro no log e redirecione para a listagem com mensagem amigável.

Arquivos prováveis: `app/Http/Controllers/ProductsController.php`, `resources/views/products/index.blade.php`.

---

## 6. Bugfix: Corrigir mensagem de erro não exibida na listagem

A listagem de produtos já exibe mensagens de sucesso, mas não exibe mensagens de erro. Ajuste a tela para mostrar `session('error')` com destaque visual em vermelho. Isso será usado por outras correções do sistema.

Arquivos prováveis: `resources/views/products/index.blade.php`.

---

## 7. Refactor: Melhorar o menu mobile do Breeze

No menu desktop aparecem links para Produtos e Tipos, mas no menu responsivo/mobile aparece apenas Dashboard. Ajuste a navegação responsiva para também exibir Produtos e Tipos quando o menu hamburger for aberto.

Arquivos prováveis: `resources/views/layouts/navigation.blade.php`.

---

## 8. Bugfix: Impedir cadastro de produto sem tipo

Atualmente o formulário permite selecionar “Selecione”, mas a validação do controller não exige explicitamente `type_id`. Ajuste a validação para exigir um tipo válido existente na tabela `types`. Exiba uma mensagem de erro abaixo do select quando o usuário não escolher um tipo.

Arquivos prováveis: `app/Http/Controllers/ProductsController.php`, `resources/views/products/create.blade.php`, `resources/views/products/edit.blade.php`.

---

## 9. Feature: Listagem de tipos

Atualmente não existe o index.blade.php para listar tipos. Implemente uma tela semelhante à listagem de produtos, mas que liste os tipos, mostrando botão de excluir ao lado de cada linha.

obs.: a edição não precisa pois como só tem nome é indicado que o usuário apague e crie outro tipo.

## 10. Random:
Se tiver uma sugestão de melhoria ou implementação, chame o professor e valide com ele o que você
irá fazer. 

## Observações para a dinâmica da aula

1. Cada dupla deve escolher apenas uma tarefa.
2. Cada dupla deve criar sua própria branch a partir da `main` atualizada.
3. A implementação deve gerar um Pull Request.
4. O professor fará comentários de revisão antes do merge.
5. Se duas duplas alterarem o mesmo arquivo, pode ser usado como exemplo real de conflito.
