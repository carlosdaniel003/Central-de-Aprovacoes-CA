<?php require_once 'src/views/header.php'; ?>

<div class="ca-container relative">
    <header class="ca-header-sys">
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--qc-green-forest); margin-right: 8px;">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Consultar Base de Aprovações
        </h1>
        <a href="index.php" class="btn btn-secondary">Voltar ao Início</a>
    </header>

    <form id="searchForm">
        <div class="section-divider"><span>Filtros de Pesquisa</span></div>
        
        <div class="form-grid">
            <div class="form-group" style="position: relative;">
                <label class="form-label">Filtrar por Modelo:</label>
                <input type="text" id="modelInput" placeholder="CARREGANDO MODELOS..." disabled class="form-control" autocomplete="off" />
                <input type="hidden" id="modelHidden" />
                <ul id="modelDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 2px solid var(--qc-green-sage); border-top: none; max-height: 250px; overflow-y: auto; z-index: 9999; margin: 0; padding: 0; list-style: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);"></ul>
            </div>

            <div class="form-group" style="position: relative;">
                <label class="form-label">Filtrar por Sintoma:</label>
                <input type="text" id="symptomInput" placeholder="SELECIONE UM SINTOMA..." class="form-control" autocomplete="off" />
                <input type="hidden" id="symptomHidden" />
                <ul id="symptomDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 2px solid var(--qc-green-sage); border-top: none; max-height: 250px; overflow-y: auto; z-index: 9999; margin: 0; padding: 0; list-style: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);"></ul>
            </div>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 10px;">
            <button type="submit" id="submitBtn" disabled class="btn btn-primary" style="flex: 2;">Aplicar Filtros</button>
            <button type="button" id="clearBtn" class="btn btn-secondary" style="flex: 1;">Limpar Tudo</button>
        </div>
        
        <p id="searchWarning" class="text-xs text-center font-bold text-red-700 uppercase mt-2" style="display: block;">
            [!] Selecione um Modelo ou Sintoma nas listas para liberar a pesquisa.
        </p>
    </form>

    <div id="errorMsg" class="alert-error mt-4" style="display: none;"></div>

    <div class="section-divider"><span>Resultados</span></div>

    <div id="loadingBox" class="text-center" style="padding: 40px; color: var(--qc-green-sage); font-weight: bold; display: block;">
        A CARREGAR DADOS DA BASE...
    </div>

    <div id="resultsGrid" class="cards-grid" style="display: none;"></div>
    
    <div id="paginationBox" style="display: none; justify-content: center; gap: 8px; margin-top: 30px; flex-wrap: wrap;"></div>

    <div id="noResultsBox" class="text-center" style="padding: 40px; border: 1px dashed var(--qc-border); border-radius: 8px; display: none;">
        <p style="color: var(--qc-green-forest); font-weight: bold; font-size: 18px;">NENHUM RESULTADO ENCONTRADO</p>
        <p style="color: var(--qc-slate); font-size: 14px;">Ajuste os filtros de pesquisa acima.</p>
    </div>

    <div id="detailModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="ca-title" style="color: var(--qc-green-forest); font-weight: bold;">Ficha Oficial da Aprovação</h2>
                <button type="button" id="closeModalBtn" class="btn btn-secondary" style="padding: 6px 12px;">X Fechar</button>
            </div>
            <div class="modal-body form-grid">
                <div>
                    <div class="form-group">
                        <label class="form-label">Modelo do Produto</label>
                        <div id="modalModel" class="form-control" style="background: var(--qc-ice); border: none;"></div>
                    </div>
                    <div class="form-group mt-4">
                        <label class="form-label">Sintoma Registrado</label>
                        <div id="modalSymptom" class="form-control" style="background: var(--qc-ice); border: none;"></div>
                    </div>
                    <div class="form-group mt-4">
                        <label class="form-label">Aprovado por</label>
                        <div id="modalApprovedBy" class="form-control" style="background: var(--qc-ice); border: none;"></div>
                    </div>
                    <div class="form-group mt-4">
                        <label class="form-label">Detalhes</label>
                        <div id="modalDetail" class="form-control" style="background: var(--qc-ice); border: none; min-height: 100px;"></div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="border: 1px solid var(--qc-border); border-radius: 6px; overflow: hidden;">
                        <div style="background: var(--qc-green-forest); color: #fff; text-align: center; padding: 6px; font-size: 12px; font-weight: bold;">FOTO DO DEFEITO</div>
                        <a id="modalPhotoLink" href="#" target="_blank" style="display: block; height: 200px; background: var(--qc-ice); padding: 10px;">
                            <img id="modalPhotoImg" src="" style="width: 100%; height: 100%; object-fit: contain;" />
                        </a>
                    </div>
                    <div style="border: 1px solid var(--qc-border); border-radius: 6px; overflow: hidden;">
                        <div style="background: var(--qc-green-forest); color: #fff; text-align: center; padding: 6px; font-size: 12px; font-weight: bold;">FICHA TÉCNICA</div>
                        <a id="modalSheetLink" href="#" target="_blank" style="display: block; height: 200px; background: var(--qc-ice); padding: 10px;">
                            <img id="modalSheetImg" src="" style="width: 100%; height: 100%; object-fit: contain;" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ==========================================
// LÓGICA FRONT-END (VANILLA JS)
// ==========================================

const DEFEITO_TRANSLATION = {
    "A1": "Sem áudio geral", "A2": "Sem áudio no canal ESQUERDO/Fone", "A3": "Sem áudio no canal DIREITO/Fone",
    "A4": "Sem áudio no MIC/Fone/Aux", "A5": "Ruido no áudio do MIC/Fone/Aux", "A6": "Ruido no áudio",
    "A7": "Vibração no Áudio", "A8": "Mal Contato no MIC/Fone/Aux", "A9": "Sem áudio no Tweteer",
    "A10": "Sem áudio no alto falante", "A11": "Vibração no Áudio SWEEP", "A12": "Volume mínimo não atua",
    "A13": "Áudio Baixo", "A14": "Sem áudio no canal do AF", "AP1": "Liga/desliga automaticamente",
    "AP2": "HI-POT/Rigidez/WI", "BAT1": "Bateria/Pilha não atua", "BAT2": "Aparelho não carrega",
    "BAT3": "Bateria Aux. Não Atua", "BT1": "Bluetooth Não Funciona", "BT2": "Ruido no Bluetooth",
    "BZ": "Buzzer não Atua", "CAP": "Calço/Quadro aparecendo", "CR1": "Controle não atua",
    "CR2": "Controle com pouca sensibilidade", "CR3": "Controle do Game", "CH1": "Chave Não Atua",
    "CONT": "Contaminação", "D1": "Não lê dvd/CD/Jogos", "D2": "CD Sai girando",
    "G1": "Não abre gaveta/Lenta/Batendo", "G2": "Abrindo e fechando automaticamente", "G3": "Gaveta abre mas não fecha",
    "G4": "Loader com ruídos", "GB": "Terra Aberto", "HP1": "Entrada da Gui/Aux Não Funciona",
    "HP2": "Saída Dupla de Áudio", "HP3": "Áudio Oscilando", "HP4": "Osciloscópio com Tensão Variada",
    "HP5": "Repetições de ECO", "HP6": "Agudo/Grave não atua", "HP7": "Pop noise",
    "LAN": "Entrada de Rede não Atua", "L1": "Lâmpada não apaga", "L2": "Lâmpada não Acende",
    "L3": "Lâmpada Fraca/Forte", "L4": "Lâmpada Piscando", "LH": "Linha Horizontal",
    "LV": "Linha Vertical", "LD1": "Led não acende", "LD2": "Led não apaga",
    "LD3": "Led/Flash Light com luz fraca", "LD4": "Led/Flash Light com luz forte", "LD5": "Led/Display piscando",
    "LD6": "Led com cor diferente", "LD7": "Led com luz invertida", "LD8": "Faltando digito no display",
    "LD9": "Excesso de Dígitos", "LD10": "Flash Light não liga", "LD11": "Flash Light Faltando Cor",
    "LD15": "Display não acende", "LD16": "Led do Equalizador não atua", "MURA": "Mancha Escura na Tela",
    "N1": "Aparelho não liga", "N2": "Aparelho não desliga", "N3": "Não Grava/Atualiza",
    "N4": "Software desatualizado", "N5": "Software Travando", "N6": "Centelhando/Ruido",
    "NC": "Não Comunica", "OPT": "Optical não Atual", "OP": "O-cell com Película",
    "OPEN": "Tampa do LOADER Aberto", "P1": "Quebrado/Danificado/Batido", "P2": "Riscado",
    "P3": "Mancha", "P4": "Com rebarba", "P5": "Empenado/Amassado",
    "P6": "Mal montado", "P7": "Abertura/Gap", "P8": "Falha de Injeção /Serigrafia",
    "P9": "Faltando", "P10": "Deslocado", "P11": "Fora do especificado",
    "P12": "Película no O-CELL", "P13": "Aparelho com corpo estranho", "P14": "Espanado",
    "PT1": "Prato não Gira", "PT2": "Prato Travado", "PBR": "Ponto Brilhante",
    "PAP": "Ponto Apagado", "Q1": "Super Aquecimento", "Q2": "Não Aquece",
    "REC": "Função REC não Grava", "RC1": "RCA Fora do especificado", "RC2": "RCA Não atua",
    "RD": "Radio Não Funciona/Sintoniza", "SD": "Falha no SD Card", "ST1": "Sem tensão",
    "ST2": "Tensão baixa", "ST3": "Tensão alta", "ST4": "Tensões variando",
    "ST5": "Placa em Curto", "ST6": "Luz de Jig", "T1": "Teclas não atua",
    "T2": "Tecla deslocada/danificada", "T3": "Função Invertida", "T4": "Tecla dura",
    "T5": "Volume diminui automaticamente", "T6": "Volume máximo não atua", "T7": "Tecla capacitiva (touch) não atua",
    "USB1": "Aparelho não lê pen drive", "USB2": "Mal contato na leitura do pen drive", "V1": "Sem imagem/sem brilho",
    "V2": "Sem vídeo no AV", "V3": "Sem video no HDMI", "V4": "Vídeo com Cor fora de Padrão",
    "V5": "Interferência na Imagem", "V6": "Sem video no RF/ANTENA", "VS1": "Falha Visual/Montagem",
    "VZL": "Vazamento de Luz", "VT1": "Ventilador não Gira", "VT2": "Ruído no Ventilador",
    "VM1": "Vazamento na Cavidade", "VM2": "Vazamento na Porta", "WS": "White Spot",
    "WI-FI": "Sem sinal de wi-fi", "WB": "White Ballance", "TC1": "Tescon Falha de Processo",
    "TC2": "Tescon Material", "GV1": "Gravação Falha de Processo", "GV2": "Gravação Material",
    "DH": "Dip teste Manutenção de equipamento", "PM1": "Potencia Máxima", "PM2": "Potencia Mínima",
    "CTT": "Equipamento de Teste", "VSL": "Equipamento de Teste", "ECJ": "Equipamento de Teste",
    "VPC1": "Equipamento de Teste", "5V": "Equipamento de Teste", "12V": "Equipamento de Teste",
    "CT": "Coating/Selador", "BP1": "Buzzer não Atua", "FF": "Falsa falha",
    "VAR": "Vazamento de AR", "POL": "Polarite Invertido", "VZG": "Vazamento de Gás",
    "ALT": "Aleta não abre/fecha", "A15": "Ruído na Hélice"
};

const SYMPTOMS_LIST = Object.entries(DEFEITO_TRANSLATION).map(([code, description]) => ({ code, description }));

let apiModels = [];
let allApprovals = [];

// Lógica de Paginação
let currentPage = 1;
const itemsPerPage = 9; // Exibe 9 itens por página
let currentFilteredApps = [];

const modelInput = document.getElementById('modelInput');
const modelHidden = document.getElementById('modelHidden');
const modelDropdown = document.getElementById('modelDropdown');
const symptomInput = document.getElementById('symptomInput');
const symptomHidden = document.getElementById('symptomHidden');
const symptomDropdown = document.getElementById('symptomDropdown');
const submitBtn = document.getElementById('submitBtn');
const searchWarning = document.getElementById('searchWarning');
const resultsGrid = document.getElementById('resultsGrid');
const paginationBox = document.getElementById('paginationBox');
const loadingBox = document.getElementById('loadingBox');
const errorMsg = document.getElementById('errorMsg');

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const resModels = await fetch('http://10.110.100.227/qualitycontrol/SIGMA/teste_integracao/uploads/sigma_api.php');
        const dataModels = await resModels.json();
        
        const arrModels = Array.isArray(dataModels) ? dataModels : (dataModels.data || []);
        
        const uniqueMap = new Map();
        arrModels.forEach(item => {
            if(item.codigo_prod && item.descricao_prod) {
                uniqueMap.set(String(item.codigo_prod).trim(), { 
                    codigo: String(item.codigo_prod).trim(), 
                    descricao: String(item.descricao_prod).trim() 
                });
            }
        });
        apiModels = Array.from(uniqueMap.values());
        modelInput.placeholder = "SELECIONE UM MODELO";
        modelInput.disabled = false;
    } catch (e) {
        console.error("Erro Modelos:", e);
        modelInput.placeholder = "ERRO AO CARREGAR";
    }

    try {
        const resApps = await fetch('src/api/buscar_aprovacoes.php');
        const dataApps = await resApps.json();
        if(dataApps.success) {
            allApprovals = dataApps.data;
            renderCards(allApprovals);
        }
    } catch(e) {
        console.error(e);
        errorMsg.innerText = "[!] Falha ao carregar a base de dados.";
        errorMsg.style.display = 'block';
    } finally {
        loadingBox.style.display = 'none';
    }
});

function checkBtn() {
    if (modelHidden.value !== '' || symptomHidden.value !== '') {
        submitBtn.disabled = false;
        searchWarning.style.display = 'none';
    } else {
        submitBtn.disabled = true;
        searchWarning.style.display = 'block';
    }
}

// ----------------------------------------------------
// MODELOS DROPDOWN
// ----------------------------------------------------
function renderModelDropdown(val) {
    modelDropdown.innerHTML = '';
    
    const filtered = apiModels.filter(m => 
        m.codigo.toLowerCase().includes(val) || 
        m.descricao.toLowerCase().includes(val)
    );
    
    if(filtered.length === 0) {
        modelDropdown.innerHTML = '<li style="padding: 12px; text-align: center; color: red; font-weight: bold; font-size: 13px;">[!] NENHUM MODELO ENCONTRADO</li>';
    } else {
        filtered.forEach(m => {
            const li = document.createElement('li');
            li.style.cssText = "padding: 12px 16px; cursor: pointer; border-bottom: 1px solid var(--qc-ice); font-size: 14px; font-weight: bold; color: var(--qc-slate); background: #fff; transition: background 0.2s;";
            
            li.onmouseenter = () => li.style.background = 'var(--qc-green-mint)';
            li.onmouseleave = () => li.style.background = '#fff';
            
            li.innerHTML = `<span style="color: var(--qc-green-forest);">[${m.codigo}]</span> ${m.descricao}`;
            
            li.addEventListener('mousedown', (e) => {
                e.preventDefault(); 
                const str = `[${m.codigo}] ${m.descricao}`;
                modelInput.value = str;
                modelHidden.value = str;
                modelDropdown.style.display = 'none';
                checkBtn();
            });
            modelDropdown.appendChild(li);
        });
    }
    modelDropdown.style.display = 'block';
}

modelInput.addEventListener('input', (e) => {
    modelHidden.value = ''; 
    checkBtn();
    renderModelDropdown(e.target.value.toLowerCase());
});

modelInput.addEventListener('focus', () => { 
    if(apiModels.length > 0) renderModelDropdown(modelInput.value.toLowerCase()); 
});

modelInput.addEventListener('blur', () => {
    setTimeout(() => {
        modelDropdown.style.display = 'none';
        if(modelHidden.value === '') {
            modelInput.value = '';
        }
    }, 200); 
});

// ----------------------------------------------------
// SINTOMAS DROPDOWN
// ----------------------------------------------------
function renderSymptomDropdown(val) {
    symptomDropdown.innerHTML = '';
    
    const filtered = SYMPTOMS_LIST.filter(s => 
        s.code.toLowerCase().includes(val) || 
        s.description.toLowerCase().includes(val)
    );
    
    if(filtered.length === 0) {
        symptomDropdown.innerHTML = '<li style="padding: 12px; text-align: center; color: red; font-weight: bold; font-size: 13px;">[!] NENHUM SINTOMA ENCONTRADO</li>';
    } else {
        filtered.forEach(s => {
            const li = document.createElement('li');
            li.style.cssText = "padding: 12px 16px; cursor: pointer; border-bottom: 1px solid var(--qc-ice); font-size: 14px; font-weight: bold; color: var(--qc-slate); background: #fff; transition: background 0.2s;";
            
            li.onmouseenter = () => li.style.background = 'var(--qc-green-mint)';
            li.onmouseleave = () => li.style.background = '#fff';
            
            li.innerHTML = `<span style="color: var(--qc-green-forest);">[${s.code}]</span> ${s.description}`;
            
            li.addEventListener('mousedown', (e) => {
                e.preventDefault(); 
                const str = `[${s.code}] ${s.description}`;
                symptomInput.value = str;
                symptomHidden.value = str;
                symptomDropdown.style.display = 'none';
                checkBtn();
            });
            symptomDropdown.appendChild(li);
        });
    }
    symptomDropdown.style.display = 'block';
}

symptomInput.addEventListener('input', (e) => {
    symptomHidden.value = ''; 
    checkBtn();
    renderSymptomDropdown(e.target.value.toLowerCase());
});

symptomInput.addEventListener('focus', () => { 
    renderSymptomDropdown(symptomInput.value.toLowerCase()); 
});

symptomInput.addEventListener('blur', () => {
    setTimeout(() => {
        symptomDropdown.style.display = 'none';
        if(symptomHidden.value === '') {
            symptomInput.value = '';
        }
    }, 200);
});

// ----------------------------------------------------
// APLICAÇÃO DOS FILTROS E RENDERIZAÇÃO
// ----------------------------------------------------
document.getElementById('searchForm').addEventListener('submit', (e) => {
    e.preventDefault();
    let filtered = allApprovals;

    if (modelHidden.value !== '') {
        filtered = filtered.filter(a => a.model === modelHidden.value);
    }
    if (symptomHidden.value !== '') {
        filtered = filtered.filter(a => a.symptom === symptomHidden.value);
    }
    
    renderCards(filtered);
});

document.getElementById('clearBtn').addEventListener('click', () => {
    modelInput.value = ''; 
    modelHidden.value = '';
    symptomInput.value = ''; 
    symptomHidden.value = '';
    checkBtn(); 
    renderCards(allApprovals);
});

// Função Inicial que Reseta a Página e Filtra
function renderCards(apps) {
    currentFilteredApps = apps;
    currentPage = 1; // Reseta para a página 1 ao aplicar novo filtro
    displayPage(currentPage);
}

// Função que Exibe Apenas os Itens da Página Atual
function displayPage(page) {
    resultsGrid.innerHTML = '';
    const noResBox = document.getElementById('noResultsBox');
    
    if (currentFilteredApps.length === 0) {
        resultsGrid.style.display = 'none';
        paginationBox.style.display = 'none';
        noResBox.style.display = 'block';
        return;
    }
    
    noResBox.style.display = 'none';
    resultsGrid.style.display = 'grid';
    paginationBox.style.display = 'flex';

    // Lógica Matemática da Paginação (Fatiando o Array)
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const appsToShow = currentFilteredApps.slice(startIndex, endIndex);

    appsToShow.forEach(app => {
        const aprovador = app.approvedBy || app.approved_by || 'Não informado';

        const html = `
        <div class="ca-card">
            <div class="card-img-box">
                <img src="${app.defectPhotoUrl}" />
            </div>
            <div class="card-body">
                <div class="card-row"><div class="card-label">Modelo</div><div class="card-value">${app.model}</div></div>
                <div class="card-row"><div class="card-label">Sintoma</div><div class="card-value">${app.symptom}</div></div>
                <div class="card-row"><div class="card-label">Aprovado por</div><div class="card-value">${aprovador}</div></div>
                <div style="margin-top:15px;">
                    <button type="button" onclick="openModal('${app.id}')" class="btn btn-secondary" style="width:100%; font-size: 12px; padding: 8px;">VER FICHA</button>
                </div>
            </div>
        </div>`;
        resultsGrid.insertAdjacentHTML('beforeend', html);
    });

    renderPaginationControls();
}

// Função que Desenha os Botões (1, 2, 3...)
function renderPaginationControls() {
    paginationBox.innerHTML = '';
    const totalPages = Math.ceil(currentFilteredApps.length / itemsPerPage);

    // Oculta paginação se tiver só 1 página
    if (totalPages <= 1) {
        paginationBox.style.display = 'none';
        return;
    }

    // Botão Anterior
    const prevBtn = document.createElement('button');
    prevBtn.innerText = '« Anterior';
    prevBtn.className = 'btn btn-secondary';
    prevBtn.style.padding = '8px 12px';
    prevBtn.style.fontSize = '12px';
    prevBtn.disabled = currentPage === 1;
    if(currentPage === 1) prevBtn.style.opacity = '0.5';
    prevBtn.onclick = () => { 
        if(currentPage > 1) { currentPage--; displayPage(currentPage); window.scrollTo(0, 0); } 
    };
    paginationBox.appendChild(prevBtn);

    // Botões Numéricos
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.innerText = i;
        pageBtn.className = i === currentPage ? 'btn btn-primary' : 'btn btn-secondary';
        pageBtn.style.padding = '8px 12px';
        pageBtn.style.fontSize = '12px';
        pageBtn.style.minWidth = '40px';
        pageBtn.onclick = () => { 
            currentPage = i; 
            displayPage(currentPage); 
            window.scrollTo(0, 0); // Sobe a página ao clicar
        };
        paginationBox.appendChild(pageBtn);
    }

    // Botão Próximo
    const nextBtn = document.createElement('button');
    nextBtn.innerText = 'Próxima »';
    nextBtn.className = 'btn btn-secondary';
    nextBtn.style.padding = '8px 12px';
    nextBtn.style.fontSize = '12px';
    nextBtn.disabled = currentPage === totalPages;
    if(currentPage === totalPages) nextBtn.style.opacity = '0.5';
    nextBtn.onclick = () => { 
        if(currentPage < totalPages) { currentPage++; displayPage(currentPage); window.scrollTo(0, 0); } 
    };
    paginationBox.appendChild(nextBtn);
}

// ----------------------------------------------------
// MODAL INTERATIVO
// ----------------------------------------------------
const detailModal = document.getElementById('detailModal');
const closeModalBtn = document.getElementById('closeModalBtn');

window.openModal = function(id) {
    const app = allApprovals.find(a => String(a.id) === String(id));
    
    if(app) {
        document.getElementById('modalModel').innerText = app.model;
        document.getElementById('modalSymptom').innerText = app.symptom;
        document.getElementById('modalDetail').innerText = app.detail;
        
        const aprovador = app.approvedBy || app.approved_by || 'Não informado';
        document.getElementById('modalApprovedBy').innerText = aprovador;
        
        document.getElementById('modalPhotoImg').src = app.defectPhotoUrl;
        document.getElementById('modalPhotoLink').href = app.defectPhotoUrl;
        document.getElementById('modalSheetImg').src = app.defectSheetUrl;
        document.getElementById('modalSheetLink').href = app.defectSheetUrl;
        
        detailModal.style.display = 'flex';
    }
};

closeModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    detailModal.style.display = 'none';
});
</script>

<?php require_once 'src/views/footer.php'; ?>