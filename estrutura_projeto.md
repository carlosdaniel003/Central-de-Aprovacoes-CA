# Central de Aprovações - Estrutura do Projeto (PHP)

## Arquitetura CA Aplicada
O projeto agora opera em uma arquitetura SSR (Server-Side Rendering) híbrida com PHP Vanilla e JavaScript no Client-side.

## Camadas e Responsabilidades
- `src/config/`: Configurações centrais (chaves de API, URLs). Nunca expor dados sensíveis no client.
- `src/services/`: Classes e funções para comunicação com APIs externas (Supabase via cURL). Isola a lógica de infraestrutura.
- `src/api/`: Endpoints (Controladores) que recebem requisições assíncronas (AJAX/Fetch) do frontend e retornam JSON.
- `src/views/`: Fragmentos de UI reutilizáveis (header, footer).
- `public/`: Arquivos estáticos e uploads temporários (se necessário).
- Raiz (`/`): Páginas de visualização principais (`index.php`, `cadastrar.php`, `buscar.php`).

## Regras de Ouro
- Separação rígida de camadas (UI nunca acessa banco diretamente).
- Todo processamento de formulário assíncrono deve responder em JSON padrão: `{ "success": bool, "data": array|null, "error": string|null }`.
- Componentes JavaScript (Client) fazem a validação visual, mas a API (PHP) é a fonte de verdade para persistência.