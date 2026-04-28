<?php require_once 'src/views/header.php'; ?>

<div class="ca-container">
    <header class="ca-header-sys">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--qc-green-forest); margin-right: 8px;">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/>
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                <path d="m9 14 2 2 4-4"/>
            </svg>
            Central de Aprovações
        </h1>
    </header>

    <div style="margin-bottom: 30px;">
        <p style="color: var(--qc-green-sage); font-size: 16px;">
            Sistema integrado corporativo para registro, armazenamento e consulta de documentações fotográficas e aprovações de produtos.
        </p>
    </div>

    <div class="section-divider">
        <span>Ações Disponíveis</span>
    </div>

    <div class="form-grid">
        <div style="border: 1px solid var(--qc-border); border-radius: 8px; padding: 20px; background: var(--qc-ice);">
            <h2 style="color: var(--qc-green-forest); margin-bottom: 10px; font-size: 18px; display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                Novo Registro
            </h2>
            <p style="font-size: 14px; margin-bottom: 20px;">Inserir modelo, sintoma, detalhes e anexar documentação técnica.</p>
            <a href="cadastrar.php" class="btn btn-primary" style="width: auto;">Acessar Formulário</a>
        </div>

        <div style="border: 1px solid var(--qc-border); border-radius: 8px; padding: 20px; background: var(--qc-ice);">
            <h2 style="color: var(--qc-green-forest); margin-bottom: 10px; font-size: 18px; display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                </svg>
                Base de Dados
            </h2>
            <p style="font-size: 14px; margin-bottom: 20px;">Pesquisar aprovações salvas no sistema corporativo.</p>
            <a href="buscar.php" class="btn btn-primary" style="width: auto;">Acessar Consultas</a>
        </div>
    </div>
</div>

<?php require_once 'src/views/footer.php'; ?>